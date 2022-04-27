<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainRequest;
use App\Services\Shared\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CrudController extends BaseController
{
    protected BaseService $service;
    protected MainRequest $request;

    protected array $columns = ['*'];
    protected array $with = [];
    protected int $length = 10;

    /**
     * CrudController constructor.
     * @param $service
     * @param $request
     */
    public function __construct(BaseService $service, MainRequest $request)
    {
        $this->service = $service;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @param MainRequest $request
     * @return JsonResponse
     */
    public function index(MainRequest $request)
    {
        return $this->handleSharedMessage(
            $this->service->index(
                $this->columns,
                $this->with,
                $request->per_page ?? $this->length,
                $request->sort_keys ?? ['id'],
                $request->sort_dir ?? ['desc'],
                $request->search ?? null
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MainRequest $request
     * @return JsonResponse
     */
    public function store(MainRequest $request)
    {
        return $this->handleSharedMessage($this->service->store($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return $this->handleSharedMessage($this->service->view($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MainRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(MainRequest $request, int $id)
    {
        return $this->handleSharedMessage($this->service->update($id, $request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->handleSharedMessage($this->service->delete($id));
    }

}
