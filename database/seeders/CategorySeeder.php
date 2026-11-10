<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Wisata Alam', 'description' => 'Pantai, gunung, danau, dan keindahan alam lainnya.'],
            ['name' => 'Wisata Budaya', 'description' => 'Tradisi, seni, dan kebudayaan suatu daerah.'],
            ['name' => 'Wisata Sejarah', 'description' => 'Tempat bersejarah, monumen, dan situs peninggalan.'],
            ['name' => 'Wisata Edukasi', 'description' => 'Museum dan tempat belajar yang menyenangkan.'],
            ['name' => 'Wisata Hiburan', 'description' => 'Tempat rekreasi dan hiburan keluarga.'],
            ['name' => 'Wisata Religi', 'description' => 'Tempat ibadah dan wisata spiritual.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
