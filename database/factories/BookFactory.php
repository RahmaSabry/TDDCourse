<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => $this->faker->realText(),
            "description" => $this->faker->realText(),
            "author_id" => Author::factory()->create()->id,
            "ISBN" => $this->faker->regexify("(\d|w){3}-(\d|\w){3}-(\d|\w){4}")
        ];
    }
}
