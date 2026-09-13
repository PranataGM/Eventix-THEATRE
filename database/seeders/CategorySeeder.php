<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Konser Musik', 'icon' => 'heroicon-o-musical-note'],
            ['name' => 'Teater & Drama', 'icon' => 'heroicon-o-film'],
            ['name' => 'Olahraga', 'icon' => 'heroicon-o-trophy'],
            ['name' => 'Seminar & Konferensi', 'icon' => 'heroicon-o-academic-cap'],
            ['name' => 'Festival', 'icon' => 'heroicon-o-sparkles'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'icon' => $cat['icon'],
            ]);
        }
    }
}
