<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reportType' => $this->faker->word,
            'reportMessage' => $this->faker->sentence,
            'dateSubmitted' => $this->faker->dateTime(),
            'user_id' => \App\Models\User::factory()->create()->id,
            'lost_item_id' => \App\Models\LostItem::factory()->create()->id,
            'found_item_id' => \App\Models\FoundItem::factory()->create()->id,
        ];
    }
}

