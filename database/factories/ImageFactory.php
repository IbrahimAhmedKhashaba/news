<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = ['1.png' , '3.png' , '4.png' , '5.png' , '6.png' , '7.png' , '8.png' , '9.png' , '11.png' , '14.png'];
        return [
            //
            'path' => 'uploads/posts/'.$images[rand(0,9)],
            // 'post_id' => Post::inRandomOrder()->first()->id,
        ];
    }
}
