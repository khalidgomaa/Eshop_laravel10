<?php
// database/factories/SubCategoryFactory.php

namespace Database\Factories;

// use App\Models\Sub_Category;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Sub_CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    // protected $model = Sub_Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            'status' => $this->faker->numberBetween(0, 1),
            'category_id' => Category::factory(), // Create a related category
        ];
    }
}
