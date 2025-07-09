<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        User::factory()->create([
            "name" => "Surya",
            "email" => "suryapratamatanzil@gmail.com",
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            "name" => "Felly",
            "email" => "felly@gmail.com",
            'password' => Hash::make('1dan8'),
        ]);
    }
}
