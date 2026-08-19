<?php
use App\Models\Product\Certificate;

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
        Schema::create('product_certificates', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('certificate_id')
                ->constrained('certificates')
                ->cascadeOnDelete();

            $table->primary(['product_id', 'certificate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_certificates');
    }
};
