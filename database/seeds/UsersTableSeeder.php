<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User Teste',
            'email' => 'teste@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'api_token' => '0182387ce3cfbb4ff18d1575ae767d291926cc69e3b67707899f6b7b6b97e808',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
