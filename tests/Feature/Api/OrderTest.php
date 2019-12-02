<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Order;
use App\OrderItem;
use App\Product;
use App\Customer;
use App\User;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function createOrder()
    {
        $customer = factory(Customer::class)->create();
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        $order = [
            'id' => 0, 
            'created_at' => '2018-08-27T02:11:43Z', 
            'status' => 'CONCLUDED', 
            'total' => round(($product1->price + $product2->price), 2),
            'buyer' => [
                'id' => $customer->id, 
                'name' => $customer->name, 
                'cpf' => $customer->cpf, 
                'email' => $customer->email, 
            ], 
            'items' => [
                [
                    'amount' => 1, 
                    'price_unit' => $product1->price,
                    'total' => $product1->price,
                    'product' => [
                        'id' => $product1->id, 
                        'sku' => $product1->sku, 
                        'title' => $product1->name, 
                    ]
                ],
                [
                    'amount' => 1, 
                    'price_unit' => $product2->price,
                    'total' => $product2->price,
                    'product' => [
                        'id' => $product2->id, 
                        'sku' => $product2->sku, 
                        'title' => $product2->name, 
                    ]
                ],
            ]
        ];
        return $order;
    }

    public function testRequiredFields()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->postJson('/v1/orders', [
            'id' => '', 
            'created_at' => '', 
            'status' => '', 
            'total' => '', 
            'buyer' => [
                'id' => '', 'name' => '', 'cpf' => '', 'email' => ''
            ], 
            'items' => [
                [
                    'amount' => '', 
                    'price_unit' => '', 
                    'total' => '', 
                    'product' => [
                        'id' => '', 'sku' => '', 'title' => ''
                    ]
                ]
            ]
        ]);


        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id', 'created_at', 'status', 'total', 'buyer.id', 'items.0.product.id', 'items.0.amount', 'items.0.price_unit', 'items.0.total']);
    }
    
    public function testNumericValuesGreaterThanZero()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->postJson('/v1/orders', [
            'total' => 0, 'items' => [['amount' => 0, 'price_unit' => 0, 'total' => 0]]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['total', 'items.0.amount', 'items.0.price_unit', 'items.0.total']);
        
        $response = $this->postJson('/v1/orders', [
            'total' => -1, 'items' => [['amount' => -1, 'price_unit' => -1, 'total' => -1]]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['total', 'items.0.amount', 'items.0.price_unit', 'items.0.total']);
    }

    public function testCreateOrder()
    {
        $user = factory(User::class)->create();
        $order = $this->createOrder();
        $response = $this->actingAs($user, 'api')->postJson('/v1/orders', $order);
        $response->assertStatus(201);
        unset($order['id']);
        $response->assertJson($order);

        $this->assertDatabaseHas('orders', [
            'status' => $order["status"],
            'total' => $order["total"],
            'customer_id' => $order["buyer"]["id"],
        ]);

        $orderResponse = json_decode($response->getContent());
        foreach($order["items"] as $item) {
            $this->assertDatabaseHas('orders_items', [
                'order_id' => $orderResponse->id,
                'product_id' => $item["product"]["id"],
                'amount' => $item["amount"],
                'price_unit' => $item["price_unit"],
                'total' => $item["total"],
            ]);
        }
    }
    
    public function testCancelOrder()
    {
        $user = factory(User::class)->create();
        $order = $this->createOrder();
        $response = $this->actingAs($user, 'api')->postJson('/v1/orders', $order);

        $orderResponse = $response->decodeResponseJson();
        $response = $this->actingAs($user, 'api')->putJson('/v1/orders/'.$orderResponse['id']);
        $response->assertJson([
            'order_id' => $orderResponse['id'],
            'status' => 'CANCELED',
        ])
        ->assertStatus(200);
        
        $order = Order::find($orderResponse['id']);
        $this->assertDatabaseHas('orders', [
            'id' => $orderResponse['id'],
            'status' => 'CANCELED',
            'cancelDate' => $order->cancelDate
        ]);
    }

    public function testShowOrders()
    {
        $user = factory(User::class)->create();
        $order = $this->createOrder();
        $response = $this->actingAs($user, 'api')->postJson('/v1/orders', $order);

        $response = $this->actingAs($user, 'api')->get('/v1/orders');
        $response->assertJsonStructure([
            '*' => [
                'id', 
                'created_at', 
                'status', 
                'total', 
                'buyer' => [
                    'id', 
                    'name', 
                    'cpf', 
                    'email'
                ], 
                'items' => [
                    '*' => [
                        'product' => [
                            'id',
                            'sku',
                            'title'
                        ], 
                        'amount', 
                        'price_unit', 
                        'total'
                    ]
                ]
            ]
        ])
        ->assertStatus(200);
    }

    public function testShowOrdersCancelled() 
    {
        $user = factory(User::class)->create();
        $order = $this->createOrder();
        $response = $this->actingAs($user, 'api')->postJson('/v1/orders', $order);

        $orderResponse = $response->decodeResponseJson();
        $response = $this->actingAs($user, 'api')->putJson('/v1/orders/'.$orderResponse['id']);

        $response = $this->actingAs($user, 'api')->get('/v1/orders');
        $response->assertJsonStructure([
            '*' => [
                'id', 
                'created_at', 
                'cancelDate', 
                'status', 
                'total', 
                'buyer' => [
                    'id', 
                    'name', 
                    'cpf', 
                    'email'
                ], 
                'items' => [
                    '*' => [
                        'product' => [
                            'id',
                            'sku',
                            'title'
                        ], 
                        'amount', 
                        'price_unit', 
                        'total'
                    ]
                ]
            ]
        ])
        ->assertStatus(200);
    }
}
