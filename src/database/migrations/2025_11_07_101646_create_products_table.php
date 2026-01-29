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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('manufacturer_id')->constrained('manufacturers')->onDelete('cascade');
            $table->string('name', 200);
            $table->string('slug', 250)->unique(); 
            $table->decimal('price', 10, 2)->default(0.00); 
            $table->integer('stock_quantity')->default(0); 
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
  
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};