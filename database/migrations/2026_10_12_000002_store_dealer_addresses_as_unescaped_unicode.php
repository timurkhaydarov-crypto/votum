<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('dealer_locations')
            ->whereNotNull('address')
            ->orderBy('id')
            ->chunk(100, function ($locations) {
                foreach ($locations as $location) {
                    $address = json_decode($location->address, true, flags: JSON_THROW_ON_ERROR);

                    DB::table('dealer_locations')
                        ->where('id', $location->id)
                        ->update([
                            'address' => json_encode(
                                $address,
                                JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE
                            ),
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // JSON escaping is a storage representation and has no semantic rollback.
    }
};
