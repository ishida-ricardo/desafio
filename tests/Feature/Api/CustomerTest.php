<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Customer;
use App\User;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testRequiredFields() 
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->postJson('/v1/customers', [
            'id', 'name', 'cpf', 'email', 'created_at', 'updated_at'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['id', 'cpf', 'name', 'email', 'created_at', 'updated_at']);
    }

    public function testUniqueFields() 
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->actingAs($user, 'api')->postJson('/v1/customers', [
            'name' => $customer->name, 'cpf' => $customer->cpf, 'email' => $customer->email
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['cpf', 'email']);
    }

    public function testCreateCustomer() 
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->make();

        $response = $this->actingAs($user, 'api')->postJson('/v1/customers', $customer->toArray());

        $response->assertJson([
            'cpf' => $customer->cpf,
            'name' => $customer->name,
            'email' => $customer->email
        ])
        ->assertStatus(201);

        $this->assertDatabaseHas('customers', [
            'cpf' => $customer->cpf,
            'name' => $customer->name,
            'email' => $customer->email,
        ]);
    }
    
}
