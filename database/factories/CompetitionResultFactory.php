<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\CompetitionResult;
use App\Models\Runner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompetitionResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->time('H:i:s');
        $end = Carbon::parse($start)->addHour()->format('H:i:s');
        return [
            'runner_id' => Runner::factory()->create()->id,
            'competition_id' => Competition::factory()->create()->id,
            'runner_start_time' => $start,
            'runner_end_time' => $end,
        ];
    }
}
