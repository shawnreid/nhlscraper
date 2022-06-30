<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test null safe will return default value if variable is null
     *
     * @return void
     */
    public function test_null_safe_helper_returns_default_value(): void
    {
        $var = null;

        $this->assertNull(_s($var));
        $this->assertEquals('test', _s($var, 'test'));
    }

    /**
     * Test null safe will not return default if variable is set
     *
     * @return void
     */
    public function test_null_safe_helper_returns_variable_if_not_null(): void
    {
        $var = 'test';
        $this->assertNotNull(_s($var));
        $this->assertEquals(_s($var), $var);
    }
}
