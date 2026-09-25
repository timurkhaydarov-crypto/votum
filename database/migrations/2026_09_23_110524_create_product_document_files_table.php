<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_document_files', function (
            Blueprint $table
        ) {
            $table->id();

            $table->foreignId('product_document_id')
                ->constrained('product_documents')
                ->cascadeOnDelete();

            $table->string('locale', 2);

            $table->string('original_name');

            $table->string('file_name');

            $table->string('file_path');

            $table->string('mime_type', 100);

            $table->unsignedBigInteger('file_size');

            $table->timestamps();

            $table->unique([
                'product_document_id',
                'locale',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'product_document_files'
        );
    }
};