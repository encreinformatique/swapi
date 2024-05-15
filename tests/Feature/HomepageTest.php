<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class HomepageTest extends TestCase
{
    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        self::assertStringContainsString('<h1>Swapi API</h1>', $response->getContent());
    }
}
