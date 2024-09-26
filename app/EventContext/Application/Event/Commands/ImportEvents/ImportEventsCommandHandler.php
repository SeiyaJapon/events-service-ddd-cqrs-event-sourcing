<?php

declare (strict_types = 1);

namespace App\EventContext\Application\Event\Commands\ImportEvents;

use App\EventContext\Domain\Event\Repositories\ThirdPartyEventRepositoryInterface;

class ImportEventsCommandHandler {
	private ThirdPartyEventRepositoryInterface $repository;

	public function __construct(ThirdPartyEventRepositoryInterface $repository) {
		$this->repository = $repository;
	}

	public function handle(ImportEventsCommand $command): void {
		$this->repository->import($command->getUrl());
	}
}