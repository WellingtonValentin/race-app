<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\Runner;
use App\Models\RunnerCompetition;
use Illuminate\Database\Eloquent\Factories\Factory;

class RunnerCompetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RunnerCompetition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'runner_id' => Runner::factory()->create()->id,
            'competition_id' => Competition::factory()->create()->id,
        ];
    }
}
