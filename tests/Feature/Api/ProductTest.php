<?php

namespace Tests\Feature\Api;

use App\Product;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testRequiredFields()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->postJson('/v1/products', [
            'id', 'sku', 'name', 'price', 'created_at', 'updated_at'
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['sku', 'name', 'price', 'created_at', 'updated_at']);
    }

    public function testUniqueFields()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        
        $response = $this->actingAs($user, 'api')->postJson('/v1/products', [
            'sku' => $product->sku,
            'name' => $product->name,
            'price' => $product->price
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'sku']);
    }

    public function testPriceZero()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make();
        
        $response = $this->actingAs($user, 'api')->postJson('/v1/products', [
            'sku' => $product->sku,
            'name' => $product->name,
            'price' => 0
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price']);
    }

    public function testPriceLessThanZero()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make();

        $response = $this->actingAs($user, 'api')->postJson('/v1/products', [
            'sku' => $product->sku,
            'name' => $product->name,
            'price' => -1
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price']);
    }

    public function testCreateProduct()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->make();

        $response = $this->actingAs($user, 'api')->postJson('/v1/products', $product->toArray());

        $response->assertJson([
            'sku' => $product->sku,
            'name' => $product->name,
            'price' => $product->price,
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'sku' => $product->sku,
            'name' => $product->name,
            'price' => $product->price,
        ]);
    }

    public function testShowProducts()
    {
        $user = factory(User::class)->create();
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        $response = $this->actingAs($user, 'api')->get('/v1/products');
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'sku', 'price', 'created_at', 'updated_at']
        ])
        ->assertStatus(200);
    }
}
