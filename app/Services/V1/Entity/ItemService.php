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

    // Override to check owner (user)
    public function index(): SharedMessage
    {
        $userId = auth()->id();
        $categories = $this->model::whereHas('category.menu', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->paginate(10);
        return new SharedMessage(__('success.update_successful'), $this->resource::collection($categories), true, null, 200);
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
