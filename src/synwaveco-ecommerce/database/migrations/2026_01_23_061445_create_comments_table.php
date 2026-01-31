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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('articleid')->constrained('articles')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('userid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->text('content');
            $table->unsignedBigInteger('is_censored')->default(0);  
            $table->unsignedBigInteger('is_enabled')->default(1);   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
