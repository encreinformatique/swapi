<?php

namespace Tests\Unit\Swapi;

use App\Models\Starship;
use App\Models\Vehicle;
use App\Swapi\Dto;
use App\Swapi\Normalizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LogicException;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class NormalizerTest extends TestCase
{
    use RefreshDatabase;

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function sets_model_correctly(): void
    {
        $normalizer = new Normalizer(new Dto());
        self::assertEquals('', $normalizer->getModel());

        $normalizer->setModel(Starship::class);
        self::assertEquals(Starship::class, $normalizer->getModel());

        $normalizer->setModel(Vehicle::class);
        self::assertEquals(Vehicle::class, $normalizer->getModel());
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function model_does_not_change_if_incorrect(): void
    {
        $normalizer = new Normalizer(new Dto());
        self::assertEquals('', $normalizer->getModel());

        $normalizer->setModel('Lorem');
        self::assertEquals('', $normalizer->getModel());
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function starship_is_normalized(): void
    {
        $normalizer = new Normalizer(new Dto());

        $reference = [
            'name' => "X-wing",
            'model' => "T-65 X-wing",
            'url' => "http://swapi.dev/api/starships/12/",
            'edited' => "2014-12-20T21:23:49.867000Z"
        ];
        $row = $normalizer->setModel(Starship::class)->normalizeRow($reference);
        self::assertArrayHasKey('name', $row);
        self::assertArrayHasKey('model', $row);
        self::assertArrayHasKey('url', $row);
        self::assertArrayHasKey('count', $row);
        self::assertEquals($reference['name'], $row['name']);
        self::assertEquals($reference['model'], $row['model']);
        self::assertEquals($reference['url'], $row['url']);
        self::assertEquals(0, $row['count']);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function vehicle_is_normalized(): void
    {
        $normalizer = new Normalizer(new Dto());

        $reference = [
            'name' => "Sand Crawler",
            'model' => "Digger Crawler",
            'url' => "http://swapi.dev/api/vehicles/4/",
            'edited' => "2014-12-20T21:23:49.867000Z"
        ];
        $row = $normalizer->setModel(Vehicle::class)->normalizeRow($reference);
        self::assertArrayHasKey('name', $row);
        self::assertArrayHasKey('model', $row);
        self::assertArrayHasKey('url', $row);
        self::assertArrayHasKey('count', $row);
        self::assertEquals($reference['name'], $row['name']);
        self::assertEquals($reference['model'], $row['model']);
        self::assertEquals($reference['url'], $row['url']);
        self::assertEquals(0, $row['count']);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function model_has_not_been_defined(): void
    {
        self::expectException(LogicException::class);;
        self::expectExceptionMessage('Model  not found in Dto');

        $normalizer = new Normalizer(new Dto());

        $normalizer->normalizeRow([
            'name' => "X-wing",
            'model' => "T-65 X-wing",
            'url' => "http://swapi.test.swapi.orb.local/api/starships/12/",
            'edited'=> "2014-12-20T21:23:49.867000Z"
        ]);
    }
}
