<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'customer_id' => 1,
            'status' => "CANCELED",
            'total' => 189.80,
            'created_at' => now(),
            'cancelDate' => now(),
        ]);
        DB::table('orders_items')->insert([
            'order_id' => 1,
            'product_id' => 1,
            'amount' => 1,
            'price_unit' => 109.90,
            'total' => 109.90,
        ]);
        DB::table('orders_items')->insert([
            'order_id' => 1,
            'product_id' => 2,
            'amount' => 1,
            'price_unit' => 79.90,
            'total' => 79.90,
        ]);
        
        DB::table('orders')->insert([
            'customer_id' => 2,
            'status' => "CONCLUDED",
            'total' => 109.90,
            'created_at' => now(),
        ]);
        DB::table('orders_items')->insert([
            'order_id' => 2,
            'product_id' => 1,
            'amount' => 1,
            'price_unit' => 109.90,
            'total' => 109.90,
        ]);
    }
}
