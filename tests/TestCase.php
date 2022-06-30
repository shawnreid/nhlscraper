<?php

namespace Tests;

use App\Models\Games\Games;
use App\Models\Seasons\Seasons;
use App\Services\Game\GameService;
use Database\Seeders\DatabaseSeeder;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Return fake response from file
     *
     * @param string $file
     * @return void
    */
    public function fakeJson(string $file): PromiseInterface
    {
        return Http::response(
            (string) \file_get_contents(\storage_path()."/fakers/{$file}.json")
        );
    }

    /**
     *  Get season
     *
     * @return Seasons
    */
    public function getSeason(): Seasons
    {
        return Seasons::find(20192020);
    }

    /**
     * Return test set of game data
     *
     * @param string $file
     * @return void
    */
    public function fakeGame(string $file): void
    {
        Http::fake(['*' => $this->fakeJson($file)]);
        $games = Games::factory()->create();
        (new GameService)->handle($games);
    }
}
