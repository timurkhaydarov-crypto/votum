<?php

namespace Database\Seeders\Contacts;

use App\Models\Contacts\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = ['whatsapp'];
        foreach ($platforms as $platform) {
            SocialMedia::query()->create([
                'platform' => $platform,
                'url' => 'https://wa.me/message/EI6YVQKAHJVXD1',
                'icon' => $platform,
            ]);
        }
    }
}
