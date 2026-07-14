<?php

namespace Database\Seeders\Contacts;

use Illuminate\Database\Seeder;
use App\Models\Contacts\SocialMedia;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = ['whatsapp', 'telegram', 'instagram'];
        foreach ($platforms as $platform) {
            SocialMedia::factory()->create([
                'platform' => $platform,
            ]);
        }
    }
}
