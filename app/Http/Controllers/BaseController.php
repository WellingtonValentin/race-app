<?php

namespace App\Http\Controllers;

use App\Services\CRUDService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var CRUDService
     */
    protected $service;

    /**
     * Controller constructor.
     *
     * @param CRUDService|null $service
     */
    public function __construct(CRUDService $service = null)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $paginate = $request->query('per_page', 10);

        $results = $this
            ->createQuery($request)
            ->list($paginate);

        return response($results);
    }

    /**
     * @param Request $request
     *
     * @return CRUDService
     */
    protected function createQuery(Request $request)
    {
        return $this
            ->service
            ->filter($request->get('search') ?? '', $request)
            ->orderBy($this->getOrderBy($request), $this->isDescending($request));
    }

    protected function getOrderBy(Request $request)
    {
        return $request
                ->get(CRUDService::ORDER_BY) ?? 'id';
    }

    protected function isDescending(Request $request)
    {
        return $request
            ->has(CRUDService::DESCENDING);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexWithoutPaginate(Request $request)
    {
        $results = $this
            ->createQuery($request)
            ->listWithoutPaginate();

        return response($results);
    }
}
