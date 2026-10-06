<?php

namespace Tests\Feature;

use Database\Seeders\ProductionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductionSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_production_seeder_populates_catalog_without_creating_users(): void
    {
        $this->seed(ProductionSeeder::class);

        $this->assertDatabaseCount('users', 0);
        $this->assertGreaterThan(0, DB::table('products')->count());
    }
}
