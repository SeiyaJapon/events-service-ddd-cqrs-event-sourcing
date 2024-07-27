<?php

declare(strict_types=1);

namespace Tests\Integration\EventContext\Infrastructure\Event\Persistence\Repository;

use App\EventContext\Infrastructure\Event\Persistence\Repository\DataThirdPartyEventRepository;
use App\EventContext\Infrastructure\Event\Services\EventDispatcherService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class DataThirdPartyEventRepositoryTest extends TestCase
{
    private MockObject $client;
    private MockObject $eventDispatcherService;
    private DataThirdPartyEventRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(Client::class);
        $this->eventDispatcherService = $this->createMock(EventDispatcherService::class);
        $this->repository = new DataThirdPartyEventRepository($this->client, $this->eventDispatcherService);
    }

    public function testImport(): void
    {
        $url = 'http://example.com/events';
        $xmlContent = <<<XML
<eventlist>
    <output>
        <base_event>
            <event event_id="123" event_start_date="2023-10-01" sell_from="2023-09-01" event_end_date="2023-10-02" sell_to="2023-09-30">
                <zone zone_id="1" capacity="100" name="Zone A" price="50.0" numbered="true" />
                <zone zone_id="2" capacity="200" name="Zone B" price="75.0" numbered="false" />
            </event>
        </base_event>
    </output>
</eventlist>
XML;

        $response = new Response(200, [], $xmlContent);
        $this->client
            ->expects($this->once())
            ->method('get')
            ->with($url)
            ->willReturn($response);

        $expectedEventData = [
            '@attributes' => [
                'event_id' => '123',
                'event_start_date' => '2023-10-01',
                'sell_from' => '2023-09-01',
                'event_end_date' => '2023-10-02',
                'sell_to' => '2023-09-30'
            ],
            'title' => 'Sample Event',
            'zone' => [
                [
                    '@attributes' => [
                        'zone_id' => '1',
                        'capacity' => 100,
                        'name' => 'Zone A',
                        'price' => 50.0,
                        'numbered' => 'true'
                    ]
                ],
                [
                    '@attributes' => [
                        'zone_id' => '2',
                        'capacity' => 200,
                        'name' => 'Zone B',
                        'price' => 75.0,
                        'numbered' => 'false'
                    ]
                ]
            ]
        ];

        $this->eventDispatcherService
            ->expects($this->any())
            ->method('dispatchEventValidated')
            ->with($expectedEventData);

        $this->repository->import($url);
    }
}