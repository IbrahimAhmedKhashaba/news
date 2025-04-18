<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $date = fake()->date('Y-m-d h:m:s');
        // Category::factory()->count(10)->create();
        $data = ['technology category' , 'sports category' , 'fashion category'];
        foreach ($data as $item) {
            Category::create([
                'name' => $item,
                'slug' => Str::slug($item),
                'small_desc' => ($item.$item.$item),
                'status' =>1,
                'created_at' => $date,
            'updated_at' => $date,
            ]);
        }
    }
}
