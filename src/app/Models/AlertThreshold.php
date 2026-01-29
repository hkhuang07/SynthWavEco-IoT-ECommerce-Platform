<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertThreshold extends Model
{
    use HasFactory;

    protected $table = 'alert_thresholds';

    protected $fillable = [
        'iot_device_id',
        'metric_key',
        'min_value',
        'max_value',
    ];

    protected $casts = [
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(IoTDevice::class, 'iot_device_id', );
    }
}
