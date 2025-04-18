<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $images = ['1.png' , '3.png' , '4.png' , '5.png' , '6.png' , '7.png' , '8.png' , '9.png' , '11.png' , '14.png'];
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' =>fake()->unique()->userName(),
            'image' => 'uploads/posts/'.$images[rand(0,9)],
            'status' => fake()->randomElement([0 , 1]),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'street' => fake()->streetAddress(),
            'phone'=> fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => Hash::make('789789789'), // password
            'remember_token' => Str::random(10),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
