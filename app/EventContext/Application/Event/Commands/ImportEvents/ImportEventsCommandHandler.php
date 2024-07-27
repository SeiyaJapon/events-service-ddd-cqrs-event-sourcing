<?php

declare(strict_types=1);

namespace App\EventContext\Application\Event\Commands\ImportEvents;

use App\EventContext\Infrastructure\Event\Persistence\Repository\DataThirdPartyEventRepository;

class ImportEventsCommandHandler
{
    private DataThirdPartyEventRepository $repository;

    public function __construct(DataThirdPartyEventRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ImportEventsCommand $command): void
    {
        $this->repository->import($command->getUrl());
    }
}