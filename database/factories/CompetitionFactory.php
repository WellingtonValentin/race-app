<?php

namespace Database\Factories;

use App\Enums\CompetitionEnum;
use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Competition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => array_rand(CompetitionEnum::getAllValues()),
            'date' => $this->faker->date(),
        ];
    }
}
