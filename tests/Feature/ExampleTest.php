<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
