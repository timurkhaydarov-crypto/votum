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
        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->json('name')->nullable()->after('dealer_id');
            $table->string('map_link')->nullable()->after('address');
            $table->string('email')->nullable()->after('map_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->dropColumn(['name', 'map_link', 'email']);
        });
    }
};
