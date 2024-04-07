<?php

namespace App\Http\Controllers\Api\V1\Core;

use App\Http\Controllers\Controller;
use App\Traits\Api\SharedMessageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{

    use SharedMessageTrait;

    protected $model;
    protected $modelService;
    protected $storeRequest;
    protected $updateRequest;
    protected $service;

    public function __construct()
    {
        $this->service = new $this->modelService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->handleSharedMessage($this->service->index());
    }

    /**
     * Store a newly created resource in storage.
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate((new $this->storeRequest())->rules());
        return $this->handleSharedMessage($this->service->store($data));
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $item = $this->model::findOrFail($id);
        return $this->handleSharedMessage($this->service->show($item));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param String $id
     * @return JsonResponse
     */
    public function update(Request $request,  $id): JsonResponse
    {
        $data = $request->validate((new $this->updateRequest())->rules());
        $item = $this->model::findOrFail($id);
        return $this->handleSharedMessage($this->service->update($data , $item));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $model_id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $item = $this->model::findOrFail($id);
        return $this->handleSharedMessage($this->service->destroy($item));
    }

}
