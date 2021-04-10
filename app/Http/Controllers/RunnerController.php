<?php
namespace App\Http\Controllers;

use App\Models\Runner;
use App\Http\Requests\RunnerRequest;
use App\Services\RunnerService;
use Illuminate\Http\Response;
use Exception;

class RunnerController extends BaseController
{
    public function __construct(RunnerService $service = null)
    {
        parent::__construct($service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RunnerRequest $request
     * @return Response
     * @throws \Exception
     */
    public function store(RunnerRequest $request)
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
     * @param  Runner  $runner
     * @return Response
     */
    public function show(Runner $runner)
    {
        return response($runner->find($runner->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RunnerRequest $request
     * @param Runner $runner
     * @return Response
     * @throws Exception
     */
    public function update(RunnerRequest $request, Runner $runner)
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
     * @param Runner $runner
     * @return Response
     * @throws Exception
     */
    public function destroy(Runner $runner)
    {
        $this
            ->service
            ->delete($runner);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
