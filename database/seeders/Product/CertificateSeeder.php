<?php

namespace Database\Seeders\Product;

use App\Models\Product\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certificates = require __DIR__.'/data/certificates.php';

        foreach ($certificates as $item) {
            Certificate::query()->create([
                'title' => $item['title'],
                'description' => $item['description'],
                'image_url' => $item['image_url'],
            ]);
        }
    }
}
