<?php

namespace Tests;

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

    public function fakeJson(): PromiseInterface
    {
        return Http::response(
            \file_get_contents(\storage_path().'/fakers/schedule.json')
        );
    }
}