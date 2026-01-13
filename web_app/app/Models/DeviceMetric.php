<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceMetric extends Model
{
    use HasFactory;
    protected $table = 'device_metrics';

    protected $fillable = [
        'iot_device_id', 
        'metric_key', 
        'description', 
        'unit'
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(IoTDevice::class, 'iot_device_id', 'id');
    }
}
