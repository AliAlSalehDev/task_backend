<?php

namespace App\Services\V1\Entity;

use App\Common\SharedMessage;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\V1\BaseService;
use App\Traits\DiscountTrait;
use Illuminate\Support\Facades\DB;

class MenuService extends BaseService
{
    use DiscountTrait;

    protected $model = Menu::class;
    protected $resource = MenuResource::class;

    protected function save($data)
    {
        try {
            DB::beginTransaction();

            // Save Category
            $data['user_id'] = auth()->id();
            $menu = $this->model::create($data);
            // Check Discount
            if (isset($data['discount'])) {
                $arr = ['element' => $menu, 'discount' => $data['discount']];
                $this->saveDiscount($arr);
            }

            DB::commit();
            return $menu;
        } catch (\Exception $exception) {
            DB::rollback();
            return new SharedMessage(__('error.store_fail'), $exception->getMessage(), false, null, 400);
        }
    }

    public function update($data, $model): SharedMessage
    {
        try {
            DB::beginTransaction();
            $model->update($data);
            if(isset($data['discount'])) {
                $this->updateDiscount($data['discount']);
            }
            DB::commit();
            return new SharedMessage(__('success.update_successful'), new $this->resource($model), true, null, 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return new SharedMessage(__('error.store_fail'), $exception->getMessage(), false, null, 400);
        }
    }

}
