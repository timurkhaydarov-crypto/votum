<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->jsonb('name');
            $table->string('version');
            $table->string('purpose')->nullable();
            $table->string('image')->nullable();
            $table->jsonb('short_description');
            $table->jsonb('full_description');
            $table->timestamps();

            $table->index(['product_id', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_apps');
    }
};
