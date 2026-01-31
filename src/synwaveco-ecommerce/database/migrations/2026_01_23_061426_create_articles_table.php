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
            Schema::create('articles', function (Blueprint $table) {
                  $table->id();

                  // Khóa ngoại
                  $table->foreignId('userid')->constrained('users')
                        ->onUpdate('cascade')
                        ->onDelete('restrict');
                  $table->foreignId('productid')->nullable()->constrained('products')
                        ->onUpdate('cascade')
                        ->onDelete('set null');
                  $table->foreignId('articletypeid')->constrained('article_types')
                        ->onUpdate('cascade')
                        ->onDelete('restrict');
                  $table->foreignId('topicid')->nullable()->constrained('topics')
                        ->onUpdate('cascade')
                        ->onDelete('set null');
                  $table->foreignId('statusid')->constrained('article_statuses')
                        ->onUpdate('cascade')
                        ->onDelete('restrict');
                  $table->string('title');
                  $table->string('slug')->unique();
                  $table->text('summary')->nullable();
                  $table->longText('content');
                  $table->string('image')->nullable();
                  $table->integer('views')->default(0);
                  $table->unsignedTinyInteger('is_enabled')->default(1); // 1: enabled, 0: disabled

                  $table->timestamps();
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::dropIfExists('articles');
      }
};
