<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Principal',
            'email' => 'prueba@jap.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}