<?php

namespace Tests;

use App\Models\Years;
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

    public function fakeJson(string $target): PromiseInterface
    {
        return Http::response(
            (string) \file_get_contents(\storage_path()."/fakers/{$target}.json")
        );
    }

    public function testYear(): Years
    {
        return new Years([
            'id'   => 20192020,
            'year' => 2019
        ]);
    }
}
