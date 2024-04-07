<?php

namespace App\Traits;

use App\Common\SharedMessage;
use App\Models\Discount;
use Illuminate\Support\Facades\DB;

trait DiscountTrait
{
    public function saveDiscount($data)
    {
        try {
            DB::beginTransaction();

            $element = $data['element'];
            $discountData = $data['discount'];

            // Save Discount From Morph Relation
            $discount = $element->discount()->create([
                'name' => $discountData['name'],
                'value' => $discountData['value'],
                'type' => $discountData['type']
            ]);

            DB::commit();
            return $discount;
        } catch (\Exception $exception) {
            DB::rollback();
            return new SharedMessage(__('error.store_fail'), $exception->getMessage(), false, null, 400);
        }
    }

    public function updateDiscount($data)
    {
        $discount = Discount::findOrFail($data['id']);
        $discount->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'value' => $data['value']
        ]);
        return $discount;
    }
}
