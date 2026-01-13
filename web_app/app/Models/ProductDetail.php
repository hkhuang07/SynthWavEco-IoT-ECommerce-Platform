<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetail extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'product_id',
        'memory',
        'cpu',
        'graphic',
        'power_specs'
    ];

    /**
     * ProductDetails thuộc về một Product (1-1).
     */
    public function product(): BelongsTo
    {
        // Khóa ngoại được đặt tên rõ ràng trong hasOne/belongsTo để đảm bảo tính nhất quán
        return $this->belongsTo(Product::class, 'product_id', 'id'); 
    }
}