<?php

namespace Ihossain\LaravelTags\Database\Factories;

use Ihossain\LaravelTags\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->sentence,
            'color' => $this->faker->randomElement([
                'slate',
                'blue',
                'purple',
                'green',
                'amber',
                'red',
            ]),
            'type' => $this->faker->randomElement(['course', 'blog']),
        ];
    }
}
