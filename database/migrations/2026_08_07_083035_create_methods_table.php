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
        Schema::create('methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->nullOnDelete();
            $table->boolean('ut_method');
            $table->boolean('et_method');
            $table->boolean('mia_method');
            $table->boolean('iet_method');
            $table->boolean('mt_method');
            $table->boolean('vt_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('methods');
    }
};
