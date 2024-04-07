<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'category_id'];

    protected $appends = ['final_price'];

    // Relations

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function discount(): morphOne
    {
        return $this->morphOne(Discount::class, 'discountable');
    }

    public function getFinalPriceAttribute(): string
    {
        // Check Item Discount
        if($this->discount)
            return calculateDiscount($this->discount, $this->price);

        // Check Categories
        $category = $this->category;
        while($category) {
            if($category->discount)
                return calculateDiscount($category->discount, $this->price);
            $category = $category->parent;
        }

        // Check Menu
        $menu = $this->category->menu;
        if($menu && $menu->discount) {
            return calculateDiscount($menu->discount, $this->price);
        }

        return formatDecimals($this->price);
    }
}
