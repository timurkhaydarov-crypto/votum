<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->text('address_ru')->nullable()->after('address');
            $table->text('address_en')->nullable()->after('address_ru');
        });

        DB::table('dealer_locations')->update([
            'address_ru' => DB::raw('address'),
            'address_en' => DB::raw('address'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->dropColumn(['address_ru', 'address_en']);
        });
    }
};
