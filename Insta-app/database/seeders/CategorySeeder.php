<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sports', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'Instruments', 'created_at' => NOW(), 'updated_at' => NOW()],
        ];

        $this->category->insert($categories);
    }
}
