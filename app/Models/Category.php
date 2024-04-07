<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'menu_id', 'parent_id'];


    // Relations

    public function menu(): belongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): belongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children(): hasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function items(): hasMany
    {
        return $this->hasMany(Item::class);
    }

    public function discount(): morphOne
    {
        return $this->morphOne(Discount::class, 'discountable');
    }
}
