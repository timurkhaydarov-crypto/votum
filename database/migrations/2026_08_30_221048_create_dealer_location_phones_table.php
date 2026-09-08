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
        Schema::create('dealer_location_phones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dealer_location_id')
                ->constrained('dealer_locations')
                ->cascadeOnDelete();

            $table->string('phone');

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealer_location_phones');
    }
};
