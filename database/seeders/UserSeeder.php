<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;
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
        $faker = Factory::create();

        User::create(['name' => 'Admin',
            'user_name' => 'ziko',
            'email' => 'admin@admin.com', 'password' => Hash::make('12345678'),
            'user_role' => 'admin',
            'email_verified' => 1, 
        
        ]);
    }
}
