<?php

namespace App\Services\V1\Entity;

use App\Common\SharedMessage;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use App\Services\V1\BaseService;
use App\Traits\DiscountTrait;
use Illuminate\Support\Facades\DB;

class ItemService extends BaseService
{
    use DiscountTrait;

    protected $model = Item::class;
    protected $resource = ItemResource::class;

    protected function save($data)
    {
        try {
            DB::beginTransaction();

            // Check Mix Items
            if(isset($data['category_id'])) {
                // Check Mix Items
                $parent = Category::withCount('children')->find($data['category_id']);

                if($parent->children_count) {
                    return null;
                }
            }

            // Save Category
            $item = $this->model::create($data);
            // Check Discount
            if (isset($data['discount'])) {
                $arr = ['element' => $item, 'discount' => $data['discount']];
                $this->saveDiscount($arr);
            }
            DB::commit();
            return $item;
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
