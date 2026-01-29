<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id', 
        'url', 
        'is_avatar' 
    ];

    protected function casts(): array
    {
        return [
            'is_avatar' => 'boolean',
        ];
    }
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}