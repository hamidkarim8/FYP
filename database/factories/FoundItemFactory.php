<?php

namespace Database\Factories;

use App\Models\FoundItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class FoundItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FoundItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'itemName' => $this->faker->word,
            'description' => $this->faker->sentence,
            'location' => $this->faker->address,
            'dateFound' => $this->faker->date(),
            'isResolved' => false,
            'user_id' => \App\Models\User::factory()->create()->id,
        ];
    }
}

