<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'name' => "Maria Aparecida de Souza",
            'email' => "mariasouza@email.com",
            'cpf' => "81258705044",
            'created_at' => '2018-08-27 02:11:43',
            'updated_at' => '2018-08-27 02:30:20'
        ]);
        DB::table('customers')->insert([
            'name' => "Lurdes da Silva",
            'email' => "lurdesdasilva@email.com",
            'cpf' => "46793282077",
            'created_at' => '2018-08-27 02:11:43',
            'updated_at' => '2018-08-27 02:30:20'
        ]);
    }
}
