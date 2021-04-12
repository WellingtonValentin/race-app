<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitionRequest;
use App\Models\Competition;
use App\Services\CompetitionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class CompetitionController extends BaseController
{
    public function __construct(CompetitionService $service = null)
    {
        parent::__construct($service);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $paginate = $request->query('per_page', 10);

        $results = $this
            ->createQuery($request)
            ->list($paginate, ['runners']);

        return response($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompetitionRequest $request
     * @return Response
     * @throws \Exception
     */
    public function store(CompetitionRequest $request)
    {
        try {
            $response = $this
                ->service
                ->create($request->toArray());
            return response($response, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Competition  $runner
     * @return Response
     */
    public function show(Competition $runner)
    {
        return response($runner->find($runner->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompetitionRequest $request
     * @param Competition $runner
     * @return Response
     * @throws Exception
     */
    public function update(CompetitionRequest $request, Competition $runner)
    {
        try {
            $response = $this
                ->service
                ->update($request, $runner);
            return response($response, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Competition $runner
     * @return Response
     * @throws Exception
     */
    public function destroy(Competition $runner)
    {
        $this
            ->service
            ->delete($runner);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
