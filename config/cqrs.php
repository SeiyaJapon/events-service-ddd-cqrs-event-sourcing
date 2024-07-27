<?php

return [
    'commands' => [
        App\EventContext\Application\Event\Commands\ImportEvents\ImportEventsCommand::class =>
            App\EventContext\Application\Event\Commands\ImportEvents\ImportEventsCommandHandler::class,
        App\EventContext\Application\Event\Commands\SaveEventCommand\SaveEventCommand::class =>
            App\EventContext\Application\Event\Commands\SaveEventCommand\SaveEventCommandHandler::class,
        App\EventContext\Application\Event\Commands\SaveZoneCommand\SaveZoneCommand::class =>
            App\EventContext\Application\Event\Commands\SaveZoneCommand\SaveZoneCommandHandler::class,
    ],
    'queries' => [
        App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQuery::class =>
            App\EventContext\Application\Event\Queries\FindByDatesQuery\FindByDatesQueryHandler::class
    ],
];
