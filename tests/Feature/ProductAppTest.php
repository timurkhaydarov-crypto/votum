<?php

namespace Tests\Feature;

use App\Models\Product\Product;
use App\Models\User;
use App\Services\ProductMediaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAppTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_apps_can_be_created_and_loaded_with_product_details(): void
    {
        $product = Product::factory()->create();
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);
        $mediaService = \Mockery::mock(ProductMediaService::class);
        $mediaService->shouldReceive('promoteProductAppImage')
            ->twice()
            ->andReturnUsing(
                fn (string $token, int $productAppId): string => "product-apps/{$productAppId}/{$token}"
            );
        $this->instance(ProductMediaService::class, $mediaService);

        $response = $this->actingAs($manager)->postJson(
            "/api/products/item/{$product->id}/apps",
            [
                'name' => [
                    'ru' => 'Приложение',
                    'en' => 'Application',
                ],
                'version' => '1.2.3',
                'image' => 'apps/icon',
                'short_description' => [
                    'ru' => 'Кратко',
                    'en' => 'Short',
                ],
                'full_description' => [
                    'ru' => 'Полное описание',
                    'en' => 'Full description',
                ],
                'image_tokens' => ['image-one', 'image-two'],
            ]
        );

        $response->assertCreated()
            ->assertJsonPath('product_app.name.ru', 'Приложение')
            ->assertJsonPath('product_app.name.en', 'Application')
            ->assertJsonPath('product_app.version', '1.2.3')
            ->assertJsonPath('product_app.image', '/image/apps/icon')
            ->assertJsonPath('product_app.images.0.sort_order', 0)
            ->assertJsonPath('product_app.images.1.sort_order', 1);

        $this->getJson("/api/products/item/{$product->id}/apps")
            ->assertOk()
            ->assertJsonCount(1, 'product_apps')
            ->assertJsonPath('product_apps.0.short_description.en', 'Short')
            ->assertJsonCount(2, 'product_apps.0.images');

        $this->getJson(
            "/api/products/item/{$product->id}/apps/"
                .$response->json('product_app.id')
        )->assertOk()
            ->assertJsonPath('product_app.version', '1.2.3');

        $this->getJson("/api/products/item/{$product->id}")
            ->assertOk()
            ->assertJsonPath('product_apps.0.id', $response->json('product_app.id'))
            ->assertJsonPath(
                'product_apps.0.images.0.image_url',
                '/image/product-apps/'
                    .$response->json('product_app.id')
                    .'/image-one.webp'
            );
    }

    public function test_product_app_lists_are_sorted_naturally_by_version(): void
    {
            $product = Product::factory()->create();

            foreach (['2.1', '2.1.3', '2.2', '1.1'] as $version) {
                $product->productApps()->create([
                    'name' => ['ru' => $version, 'en' => $version],
                    'version' => $version,
                    'short_description' => ['ru' => 'Кратко', 'en' => 'Short'],
                    'full_description' => ['ru' => 'Полное', 'en' => 'Full'],
                ]);
            }

            $this->getJson("/api/products/item/{$product->id}/apps")
                ->assertOk()
                ->assertJsonPath(
                    'product_apps',
                    fn (array $apps): bool => array_column($apps, 'version')
                        === ['1.1', '2.1', '2.1.3', '2.2']
                );

            $this->getJson("/api/products/item/{$product->id}")
                ->assertOk()
                ->assertJsonPath('product_apps.0.version', '1.1');
    }

    public function test_product_app_fields_can_be_updated_and_unrelated_product_apps_are_hidden(): void
    {
        $product = Product::factory()->create();
        $otherProduct = Product::factory()->create();
        $productApp = $product->productApps()->create([
            'name' => ['ru' => 'До', 'en' => 'Before'],
            'version' => '1.0',
            'short_description' => ['ru' => 'Кратко', 'en' => 'Short'],
            'full_description' => ['ru' => 'Полное', 'en' => 'Full'],
        ]);
        $foreignApp = $otherProduct->productApps()->create([
            'name' => ['ru' => 'Другой', 'en' => 'Other'],
            'version' => '1.0',
            'short_description' => ['ru' => 'Кратко', 'en' => 'Short'],
            'full_description' => ['ru' => 'Полное', 'en' => 'Full'],
        ]);
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $this->actingAs($manager)->patchJson(
            "/api/products/item/{$product->id}/apps/{$productApp->id}",
            [
                'name' => [
                    'ru' => 'После',
                    'en' => 'After',
                ],
                'version' => '2.0',
            ]
        )->assertOk()
            ->assertJsonPath('product_app.name.en', 'After')
            ->assertJsonPath('product_app.version', '2.0');

        $this->actingAs($manager)->deleteJson(
            "/api/products/item/{$product->id}/apps/{$foreignApp->id}"
        )->assertNotFound();

        $this->assertDatabaseHas('product_apps', [
            'id' => $foreignApp->id,
            'product_id' => $otherProduct->id,
        ]);
    }

    public function test_photos_can_be_added_removed_and_reordered(): void
    {
        $product = Product::factory()->create();
        $productApp = $product->productApps()->create([
            'name' => ['ru' => 'Приложение', 'en' => 'Application'],
            'version' => '1.0',
            'short_description' => ['ru' => 'Кратко', 'en' => 'Short'],
            'full_description' => ['ru' => 'Полное', 'en' => 'Full'],
        ]);
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);
        $mediaService = \Mockery::mock(ProductMediaService::class);
        $mediaService->shouldReceive('promoteProductAppImage')
            ->twice()
            ->andReturnUsing(
                fn (string $token, int $productAppId): string => "product-apps/{$productAppId}/{$token}"
            );
        $mediaService->shouldReceive('deleteProductAppImage')
            ->zeroOrMoreTimes();
        $this->instance(ProductMediaService::class, $mediaService);

        $response = $this->actingAs($manager)->postJson(
            "/api/products/item/{$product->id}/apps/{$productApp->id}/images",
            ['tokens' => ['image-one', 'image-two']]
        );

        $response->assertCreated()
            ->assertJsonCount(2, 'images');
        $imageIds = collect($response->json('images'))
            ->pluck('id')
            ->all();

        $this->putJson(
            "/api/products/item/{$product->id}/apps/{$productApp->id}/images/order",
            ['image_ids' => array_reverse($imageIds)]
        )->assertOk()
            ->assertJsonPath('images.0.id', $imageIds[1]);

        $this->deleteJson(
            "/api/products/item/{$product->id}/apps/{$productApp->id}/images/{$imageIds[1]}"
        )->assertOk();

        $this->assertDatabaseMissing('product_app_images', [
            'id' => $imageIds[1],
        ]);
        $this->assertDatabaseHas('product_app_images', [
            'id' => $imageIds[0],
            'product_app_id' => $productApp->id,
        ]);
    }

    public function test_product_and_app_deletion_cascade_to_app_images(): void
    {
        $product = Product::factory()->create();
        $productApp = $product->productApps()->create([
            'name' => ['ru' => 'Приложение', 'en' => 'Application'],
            'version' => '1.0',
            'short_description' => ['ru' => 'Кратко', 'en' => 'Short'],
            'full_description' => ['ru' => 'Полное', 'en' => 'Full'],
        ]);
        $productApp->images()->create([
            'image_url' => "product-apps/{$productApp->id}/image-one",
            'sort_order' => 0,
        ]);
        $productApp->images()->create([
            'image_url' => "product-apps/{$productApp->id}/image-two",
            'sort_order' => 1,
        ]);

        $productApp->delete();

        $this->assertDatabaseMissing('product_apps', [
            'id' => $productApp->id,
        ]);
        $this->assertDatabaseMissing('product_app_images', [
            'product_app_id' => $productApp->id,
        ]);

        $secondProductApp = $product->productApps()->create([
            'name' => ['ru' => 'Приложение', 'en' => 'Application'],
            'version' => '1.0',
            'short_description' => ['ru' => 'Кратко', 'en' => 'Short'],
            'full_description' => ['ru' => 'Полное', 'en' => 'Full'],
        ]);
        $secondProductApp->images()->create([
            'image_url' => "product-apps/{$secondProductApp->id}/image-three",
            'sort_order' => 0,
        ]);

        $product->delete();

        $this->assertDatabaseMissing('product_apps', [
            'id' => $secondProductApp->id,
        ]);
        $this->assertDatabaseMissing('product_app_images', [
            'product_app_id' => $secondProductApp->id,
        ]);
    }

    public function test_app_creation_requires_a_name_in_both_languages(): void
    {
        $product = Product::factory()->create();
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $this->actingAs($manager)->postJson(
            "/api/products/item/{$product->id}/apps",
            [
                'name' => ['ru' => 'Название'],
                'version' => '1.0',
            ]
        )->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name.en',
                'short_description',
                'full_description',
            ]);

        $this->assertDatabaseCount('product_apps', 0);
    }

    public function test_app_creation_rejects_null_required_descriptions(): void
    {
        $product = Product::factory()->create();
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $this->actingAs($manager)->postJson(
            "/api/products/item/{$product->id}/apps",
            [
                'name' => ['ru' => 'Название', 'en' => 'Application'],
                'version' => '1.0',
                'short_description' => null,
                'full_description' => null,
            ]
        )->assertUnprocessable()
            ->assertJsonValidationErrors([
                'short_description',
                'full_description',
            ]);

        $this->assertDatabaseCount('product_apps', 0);
    }
}
