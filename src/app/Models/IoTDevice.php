<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IoTDevice extends Model
{
    use HasFactory;

    protected $table = 'iot_devices';

    protected $fillable = [
        'product_id',
        'device_id',
        'location',
        'is_active',
        'last_seen',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_seen' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(DeviceMetric::class, 'iot_device_id', 'id');
    }

    public function thresholds(): HasMany
    {
        return $this->hasMany(AlertThreshold::class, 'iot_device_id', 'id');
    }
}
