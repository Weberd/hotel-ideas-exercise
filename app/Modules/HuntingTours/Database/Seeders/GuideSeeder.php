<?php

namespace App\Modules\HuntingTours\Database\Seeders;

use App\Modules\HuntingTours\Models\Guide;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            ['name' => 'Василий Охотников', 'experience_years' => 15, 'is_active' => true],
            ['name' => 'Иван Лесничий', 'experience_years' => 8, 'is_active' => true],
            ['name' => 'Петр Следопыт', 'experience_years' => 12, 'is_active' => true],
            ['name' => 'Михаил Зверолов', 'experience_years' => 5, 'is_active' => true],
            ['name' => 'Алексей Промысловик', 'experience_years' => 20, 'is_active' => false],
        ];

        foreach ($guides as $guide) {
            Guide::create($guide);
        }
    }
}
