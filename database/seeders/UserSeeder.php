<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'user',
                'last_name' => 'user',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('user');
        });

        $admin = User::where('id',1)->first();
        $admin->assignRole('admin');

        $user = User::where('id',2)->first();
        $user->assignRole('user');
    }
}
