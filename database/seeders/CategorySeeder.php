<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Icon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'User management', 'icon' => 'userGroup']
        ];

        foreach ($categories as $category) {
            $iconId = Icon::where('name', $category['icon'])->pluck('id')->first();

            Category::create([
                'name' => $category['name'],
                'icon_id' => $iconId,
            ]);
        }

    }
}
