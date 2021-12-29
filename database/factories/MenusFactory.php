<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title(),
            'navigation_menu' => 1,
            'footer_menu' => 0
        ];
    }
}
