<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\CompetitionResult;
use App\Models\Runner;
use App\Models\RunnerCompetition;
use Tests\TestCase;

class CompetitionResultControllerTest extends TestCase
{
    const ENDPOINT = '/api/competition-results';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCompetitionResults()
    {
        CompetitionResult::factory()->count(10)->create();

        $response = $this
            ->json('GET', self::ENDPOINT)
            ->assertStatus(200);

        $arrayAssertCount = $response->json();
        $this->assertCount(10, $arrayAssertCount['data']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCompetitionResultsCreate()
    {
        $runner = Runner::factory()->create();
        $competition = Competition::factory()->create();
        RunnerCompetition::factory()->create([
            'runner_id' => $runner->id,
            'competition_id' => $competition->id,
        ]);

        $competitionResult = [
            "runner_start_time" => "12:10:00",
            "runner_end_time" => "12:11:00",
            "runner" => [
                "id" => $runner->id,
            ],
            "competition" => [
                "id" => $competition->id,
            ],
        ];

        $response = $this
            ->json('POST', self::ENDPOINT, $competitionResult);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                "runner_start_time" => "12:10:00",
                "runner_end_time" => "12:11:00",
                'runner_id' => $runner->id,
                'competition_id' => $competition->id,
            ]);
    }

    public function testCompetitionResultsUpdate()
    {
        $competitionResult = CompetitionResult::factory()->create();
        RunnerCompetition::factory()->create([
            'runner_id' => $competitionResult->runner_id,
            'competition_id' => $competitionResult->competition_id,
        ]);

        $categoriaAlterada = [
            "runner_start_time" => "12:10:00",
            "runner_end_time" => "12:11:00",
            "runner" => [
                "id" => $competitionResult->runner_id,
            ],
            "competition" => [
                "id" => $competitionResult->competition_id,
            ],
        ];


        $uri = sprintf('%s/%s', self::ENDPOINT, $competitionResult->id);

        $response = $this
            ->json('PUT', $uri, $categoriaAlterada);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                "runner_start_time" => "12:10:00",
                "runner_end_time" => "12:11:00",
                'runner_id' => $competitionResult->runner_id,
                'competition_id' => $competitionResult->competition_id,
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCompetitionResultsCreateWithoutCompetition()
    {
        $runner = Runner::factory()->create();
        $competition = Competition::factory()->create();

        $competitionResult = [
            "runner_start_time" => "12:10:00",
            "runner_end_time" => "12:11:00",
            "runner" => [
                "id" => $runner->id,
            ],
            "competition" => [
                "id" => $competition->id,
            ],
        ];

        $response = $this
            ->json('POST', self::ENDPOINT, $competitionResult);

        $response
            ->assertStatus(400);

        $this
            ->assertEquals(
                $response->getContent(),
                'Este competidor não está cadastrado nesta competição'
            );
    }
}
