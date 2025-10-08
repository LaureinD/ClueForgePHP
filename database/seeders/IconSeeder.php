<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icons = [
            'user',
            'userGroup',
            'userPlus',
            'arrowPath',
            'informationCircle',
            'informationCircleSolid',
            'rectangleGroup',
            'chevronLeft',
            'chevronRight',
            'chevronUp',
            'chevronDown',
            'check',
            'checkCircle',
            'checkCircleSolid',
            'x',
            'xCircle',
            'xCircleSolid',
            'warning',
            'warningSolid',
            'trash',
            'pencilSquare',
            'plus'
        ];

        foreach ($icons as $icon) {
            Icon::create([
                'name' => $icon,
            ]);
        }
    }
}
