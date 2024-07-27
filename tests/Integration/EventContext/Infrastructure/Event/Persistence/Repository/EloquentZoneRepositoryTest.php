<?php

declare(strict_types=1);

namespace Tests\Integration\EventContext\Infrastructure\Event\Persistence\Repository;

use App\EventContext\Domain\Event\Zone;
use App\EventContext\Infrastructure\Event\Persistence\Repository\EloquentZoneRepository;
use App\Models\Zone as ZoneModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentZoneRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var EloquentZoneRepository */
    private $zoneRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->zoneRepository = new EloquentZoneRepository();
    }

    public function testFindByEventId(): void
    {
        $zoneModel = new ZoneModel();
        $zoneModel->id = '1';
        $zoneModel->event_id = '1';
        $zoneModel->name = 'Zone A';
        $zoneModel->capacity = 100;
        $zoneModel->price = 50.0;
        $zoneModel->numbered = true;
        $zoneModel->save();

        Cache::shouldReceive('remember')
            ->once()
            ->andReturnUsing(function ($key, $ttl, $callback) use ($zoneModel) {
                return $callback();
            });

        $result = $this->zoneRepository->findByEventId('1');

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Zone::class, $result[0]);
        $this->assertEquals('1', $result[0]->getId());
    }

    public function testSave(): void
    {
        $zone = new Zone('1', '1', 'Zone A', 100, 50.0, true);

        ZoneModel::shouldReceive('find')
            ->once()
            ->with('1')
            ->andReturn(null);

        ZoneModel::shouldReceive('save')
            ->once()
            ->andReturn(true);

        Cache::shouldReceive('put')
            ->once()
            ->with("zone_1", $zone, 3600)
            ->andReturn(true);

        $this->zoneRepository->save($zone);

        $this->assertDatabaseHas('zones', [
            'id' => '1',
            'event_id' => '1',
            'name' => 'Zone A',
            'capacity' => 100,
            'price' => 50.0,
            'numbered' => true,
        ]);
    }
}