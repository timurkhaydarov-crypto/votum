<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string(
                'documentation_key_hash',
                64
            )
                ->nullable()
                ->unique()
                ->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(
                'users_documentation_key_hash_unique'
            );

            $table->dropColumn(
                'documentation_key_hash'
            );
        });
    }
};