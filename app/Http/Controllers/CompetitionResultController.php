<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitionResultRequest;
use App\Models\CompetitionResult;
use App\Services\CompetitionResultService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class CompetitionResultController extends BaseController
{
    public function __construct(CompetitionResultService $service = null)
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
            ->list($paginate, ['runner','competition']);

        return response($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompetitionResultRequest $request
     * @return Response
     * @throws \Exception
     */
    public function store(CompetitionResultRequest $request)
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
     * @param  CompetitionResult  $runner
     * @return Response
     */
    public function show(CompetitionResult $runner)
    {
        return response($runner->find($runner->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompetitionResultRequest $request
     * @param CompetitionResult $runner
     * @return Response
     * @throws Exception
     */
    public function update(CompetitionResultRequest $request, CompetitionResult $runner)
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
     * @param CompetitionResult $runner
     * @return Response
     * @throws Exception
     */
    public function destroy(CompetitionResult $runner)
    {
        $this
            ->service
            ->delete($runner);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
