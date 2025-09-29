<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(1);
        if (!$admin) return;

        $admin->avatar()->create([
            'path' => 'img/avatars/admin.png',
            'alt' => 'admin avatar',
            'type' => 'image/png',
            'size' => 4470,
            'is_primary' => true,
        ]);
    }
}
