<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 
        'manufacturer_id', 
        'name', 
        'slug', 
        'price', 
        'stock_quantity', 
        'description'
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    public function details(): HasOne
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function iotDevices(): HasMany
    {
        return $this->hasMany(IoTDevice::class, 'product_id', 'id');
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id')
                    ->where('is_avatar', true)
                    ->latest(); // Lấy bản ghi mới nhất nếu có nhiều avatar (hoặc dùng first() nếu muốn chính xác 1)
    }
}