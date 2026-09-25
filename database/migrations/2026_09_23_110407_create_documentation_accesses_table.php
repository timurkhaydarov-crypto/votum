<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentation_accesses', function (
            Blueprint $table
        ) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->timestamp('starts_at')
                ->nullable();

            $table->timestamp('expires_at')
                ->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamp('last_accessed_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'product_id',
            ]);

            $table->index([
                'user_id',
                'is_active',
            ]);

            $table->index([
                'product_id',
                'is_active',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'documentation_accesses'
        );
    }
};