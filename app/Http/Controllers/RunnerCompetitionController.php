<?php

namespace App\Http\Controllers;

use App\Http\Requests\RunnerCompetitionRequest;
use App\Models\RunnerCompetition;
use App\Services\RunnerCompetitionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class RunnerCompetitionController extends BaseController
{
    public function __construct(RunnerCompetitionService $service = null)
    {
        parent::__construct($service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RunnerCompetitionRequest $request
     * @return Response
     * @throws \Exception
     */
    public function store(RunnerCompetitionRequest $request)
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
     * @param  RunnerCompetition  $runner
     * @return Response
     */
    public function show(RunnerCompetition $runner)
    {
        return response($runner->find($runner->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RunnerCompetitionRequest $request
     * @param RunnerCompetition $runner
     * @return Response
     * @throws Exception
     */
    public function update(RunnerCompetitionRequest $request, RunnerCompetition $runner)
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
     * @param RunnerCompetition $runner
     * @return Response
     * @throws Exception
     */
    public function destroy(RunnerCompetition $runner)
    {
        $this
            ->service
            ->delete($runner);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
