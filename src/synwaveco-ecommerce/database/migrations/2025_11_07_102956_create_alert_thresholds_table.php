<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alert_thresholds', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('iot_device_id')->constrained('iot_devices')->onDelete('cascade');
            $table->string('metric_key', 20); 
            $table->decimal('min_value', 8, 2)->nullable(); 
            $table->decimal('max_value', 8, 2)->nullable(); 
            $table->unique(['iot_device_id', 'metric_key']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_thresholds');
    }
};