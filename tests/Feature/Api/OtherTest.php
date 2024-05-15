<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class OtherTest extends TestCase
{
    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_not_found_for_unknown_endpoints(): void
    {
        $response = $this->getJson('/api/fake');

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'I have a bad feeling about this.']);
    }
}
