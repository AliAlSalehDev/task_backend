<?php

namespace App\Services\V1;

use App\Common\SharedMessage;
use App\Services\V1\ServiceInterface;

abstract class BaseService implements ServiceInterface
{
    protected $resource;
    protected $model;
    abstract protected function save($data);

    public function index()
    {
        $data = $this->model::paginate(10);
        $data->setCollection(collect($this->resource::collection($data)));
        return new SharedMessage(__('success.index_successful'), $this->resource::collection($data), true, null, 200);
    }

    public function store($data): SharedMessage
    {
        $model = $this->save($data);
        if (is_object($model)) {
            return new SharedMessage(__('success.store_successful'), new $this->resource($model), true, null, 201);
        } elseif (is_array($model)) {
            return new SharedMessage(__('success.store_successful'), $this->resource::collection($model), true, null, 201);
        }

        return new SharedMessage(__('error. invalid_model'), null, false, null, 400);
    }

    public function show($data): SharedMessage
    {
        if($data)
            return new SharedMessage(__('success.show_successful'), new $this->resource($data), true, null, 200);
        return new SharedMessage(__('error.show_fail'), [], false, null, 400);
    }

    public function update(array $data, $model): SharedMessage
    {
        $result = $model->update($data);
        if($result)
            return new SharedMessage(__('success.update_successful'), new $this->resource($model), true, null, 200);
        return new SharedMessage(__('error.update_fail'), [], false, null, 400);
    }

    public function destroy($model): SharedMessage
    {
        $result = $model->delete();
        if ($result) {
            return new SharedMessage(__('success.delete_successful'), [], true, null, 200);
        }
        return new SharedMessage(__('error.delete_fail'), [], false, null, 400);
    }

}
