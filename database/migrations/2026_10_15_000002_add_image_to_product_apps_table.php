<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('product_apps', 'image')) {
            return;
        }

        Schema::table('product_apps', function (Blueprint $table) {
            $table->string('image')->nullable()->after('version');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('product_apps', 'image')) {
            return;
        }

        Schema::table('product_apps', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
