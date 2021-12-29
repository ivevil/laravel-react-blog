<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(),
            'body' => $this->faker->paragraph(),
            'featured_image' => $this->faker->city(),
            'userid' => 1,
            'categoryid' => 1
        ];
    }
}
