<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'first_name' => 'Abdulwahab',
            'last_name' => 'Daudi',
            'email' => 'abdulwahabdaudi@gmail.com',
            'phone' => '0755373215',
            'role' => '1',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678')
        ]);
    }
}
