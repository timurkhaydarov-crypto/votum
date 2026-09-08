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
        Schema::table('requests', function (Blueprint $table) {
            $table->string('number')
                ->nullable()
                ->unique()
                ->after('id');

            $table->string('session_id')
                ->nullable()
                ->index()
                ->after('number');

            $table->string('status')
                ->default('pending')
                ->change();

            $table->string('email')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropUnique(['number']);
            $table->dropIndex(['session_id']);

            $table->dropColumn([
                'number',
                'session_id',
            ]);

            $table->string('status')
                ->default('new')
                ->change();

            $table->string('email')
                ->nullable(false)
                ->change();
        });
    }
};

