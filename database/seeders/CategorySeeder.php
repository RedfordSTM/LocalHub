<?php

namespace Database\Seeders;

use App\Enums\PublicationCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (PublicationCategory::cases() as $category) {
            Category::updateOrCreate(
                ['nom' => $category->label()],
                ['nom' => $category->label()],
            );
        }
    }
}
