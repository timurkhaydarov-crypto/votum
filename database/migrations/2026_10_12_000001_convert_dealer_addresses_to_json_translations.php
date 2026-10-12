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
            $table->json('address_translations')->nullable();
        });

        DB::table('dealer_locations')->orderBy('id')->chunk(100, function ($locations) {
            foreach ($locations as $location) {
                DB::table('dealer_locations')
                    ->where('id', $location->id)
                    ->update([
                        'address_translations' => json_encode([
                            'ru' => $location->address_ru ?? $location->address ?? '',
                            'en' => $location->address_en ?? $location->address ?? '',
                        ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    ]);
            }
        });

        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->dropColumn(['address', 'address_ru', 'address_en']);
        });

        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->renameColumn('address_translations', 'address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->text('address_legacy')->nullable();
            $table->text('address_ru')->nullable();
            $table->text('address_en')->nullable();
        });

        DB::table('dealer_locations')->orderBy('id')->chunk(100, function ($locations) {
            foreach ($locations as $location) {
                $address = json_decode($location->address, true, flags: JSON_THROW_ON_ERROR);
                $ru = $address['ru'] ?? $address['en'] ?? '';
                $en = $address['en'] ?? $address['ru'] ?? '';

                DB::table('dealer_locations')
                    ->where('id', $location->id)
                    ->update([
                        'address_legacy' => $ru,
                        'address_ru' => $ru,
                        'address_en' => $en,
                    ]);
            }
        });

        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->dropColumn('address');
        });

        Schema::table('dealer_locations', function (Blueprint $table) {
            $table->renameColumn('address_legacy', 'address');
        });
    }
};
