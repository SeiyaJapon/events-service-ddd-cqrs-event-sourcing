<?php

declare (strict_types=1);

namespace App\EventContext\Infrastructure\Event\Persistence\Repository;

use App\EventContext\Domain\Event\Event;
use App\EventContext\Domain\Event\Repositories\ThirdPartyEventRepositoryInterface;
use App\EventContext\Infrastructure\Event\Services\EventDispatcherService;
use GuzzleHttp\Client;

class DataThirdPartyEventRepository implements ThirdPartyEventRepositoryInterface
{
    private Client $client;
    private EventDispatcherService $eventDispatcherService;

    public function __construct(Client $client, EventDispatcherService $eventDispatcherService)
    {
        $this->client = $client;
        $this->eventDispatcherService = $eventDispatcherService;
    }

    public function import(string $url): void
    {
        $response = $this->client->get($url);
        $xml = simplexml_load_string($response->getBody()->getContents());

        // Firstly I thought about returning an array of base events using a query or service. This sure works for a
        // common quantity of events. Should be a service like this:
        // $baseEventsArray = [];
        //
        // foreach ($xml->output->base_event as $baseEvent) {
        //     $baseEventsArray[] = json_decode(json_encode($baseEvent), true);
        // }
        //
        // return $baseEventsArray;
        //
        // But if we have a huge amount of events, we could have performance issues. For this reason I decided use
        // events to process the third party events in a more efficient way.

        foreach ($xml->output->base_event as $baseEvent) {
            $baseEventArray = json_decode(json_encode($baseEvent), true);

            if (Event::isValid($baseEventArray)) {
                $baseEventArray['event']['title'] = $baseEventArray['@attributes']['title'];
                $this->eventDispatcherService->dispatchEventValidated($baseEventArray);
            }
        }
    }
}