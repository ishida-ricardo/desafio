<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => "Casaco Jaqueta Outletdri Inverno Jacquard",
            'sku' => 8552515751438644,
            'price' => 109.90,
            'created_at' => '2018-08-27 02:11:43',
            'updated_at' => '2018-08-27 02:30:20'
        ]);
        DB::table('products')->insert([
            'name' => "Camiseta Colcci Estampada Azul",
            'sku' => 8552515751438645,
            'price' => 79.90,
            'created_at' => '2018-08-27 02:11:43',
            'updated_at' => '2018-08-27 02:30:20'
        ]);
    }
}
