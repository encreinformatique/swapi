<?php

namespace Tests\Feature\Api;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class DocumentationTest extends TestCase
{
    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_documentation_returns_a_successful_response(): void
    {
        $response = $this->getJson('/api/documentation');

        $response->assertStatus(200);
    }
    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_documentation_json_returns_a_successful_response(): void
    {
        $response = $this->getJson('docs/api-docs.json');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'info',
                'paths'
            ]);
    }
}
