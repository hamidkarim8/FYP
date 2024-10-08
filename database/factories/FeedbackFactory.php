<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class FeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'feedbackMessage' => $this->faker->sentence,
            'dateSubmitted' => $this->faker->dateTime(),
            'user_id' => \App\Models\User::factory()->create()->id,
        ];
    }
}

