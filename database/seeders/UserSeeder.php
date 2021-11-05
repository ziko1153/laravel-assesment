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

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Ziko',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
