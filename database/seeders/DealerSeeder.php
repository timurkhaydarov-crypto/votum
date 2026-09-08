<?php

namespace Database\Seeders;

use App\Models\Dealer\Dealer;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dealers = require __DIR__ . '/Dealer/data/dealers.php';

        foreach ($dealers as $dealerData) {
            $locations = $dealerData['locations'];

            unset($dealerData['locations']);

            $dealer = Dealer::updateOrCreate(
                [
                    'country' => $dealerData['country'],
                ],
                $dealerData
            );

            foreach ($locations as $locationData) {
                $phones = $locationData['phones'] ?? [];

                unset($locationData['phones']);

                $location = $dealer->locations()->updateOrCreate(
                    [
                        'address' => $locationData['address'],
                    ],
                    $locationData
                );

                $location->phones()->delete();

                foreach ($phones as $index => $phone) {
                    $location->phones()->create([
                        'phone' => $phone,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }
    }
}