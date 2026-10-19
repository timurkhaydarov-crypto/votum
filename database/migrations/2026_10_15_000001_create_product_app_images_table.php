<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_app_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_app_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('image_url');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['product_app_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_app_images');
    }
};
