<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'user_id'];


    // Relations
    public function categories(): hasMany
    {
        return $this->hasMany(Category::class);
    }

    public function discount(): morphOne
    {
        return $this->morphOne(Discount::class, 'discountable');
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
