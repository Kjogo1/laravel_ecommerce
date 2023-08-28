<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'quantity',
        'discount_id',
        // 'inventory_id',
        'category_id'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function discount(): BelongsTo {
        return $this->belongsTo(Discount::class);
    }
}
