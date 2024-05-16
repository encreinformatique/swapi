<?php

namespace Tests\Unit\Swapi;

use App\Models\Starship;
use App\Models\Vehicle;
use App\Swapi\Dto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LogicException;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class DtoTest extends TestCase
{
    use RefreshDatabase;

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function extract_id_from_url(): void
    {
        $dto = new Dto();
        $pKey = $dto->extractKeyFromUrl('https://swapi.dev/api/starships/15/');

        self::assertEquals(15, $pKey);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function extract_id_from_url_with_whatever_host(): void
    {
        $dto = new Dto();
        $pKey = $dto->extractKeyFromUrl('https://example.com/api/vehicles/1/');

        self::assertEquals(1, $pKey);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function failed_to_extract_id(): void
    {
        $dto = new Dto();
        $pKey = $dto->extractKeyFromUrl('https://swapi.dev/api/starships/');

        self::assertNull($pKey);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function model_is_accepted(): void
    {
        $dto = new Dto();

        $entity = $dto->findOrCreate(1, [], Starship::class);
        self::assertInstanceOf(Starship::class, $entity);

        $entity = $dto->findOrCreate(1, [], Vehicle::class);
        self::assertInstanceOf(Vehicle::class, $entity);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function model_is_not_accepted(): void
    {
        self::expectException(LogicException::class);;
        self::expectExceptionMessage('Model \App\Models\Fake not found in Dto');

        $dto = new Dto();

        $dto->findOrCreate(1, [], '\App\Models\Fake');
    }
}
