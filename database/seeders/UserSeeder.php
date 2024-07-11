<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Admin',
            'email' => 'admin31@gmail.com',
            'password' => Hash::make('123456789'), 
            'role' => 'admin'
        ]);
       User::factory()->count(5)->create();

    }
}
