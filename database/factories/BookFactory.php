<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Category;

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
            'name' => $this->faker->sentence(),
            'author_id' =>Author::factory()->create()->getKey(),
            'category_id' =>Category::factory()->create()->getKey(),
            'publication_date' => $this->faker->date(),
        ];
    }
}
