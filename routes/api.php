<?php

use App\EventContext\Infrastructure\Event\Http\FindEventsByDateController;
use App\EventContext\Infrastructure\Event\Http\ImportEventsController;
use Illuminate\Support\Facades\Route;


Route::get('aux', function () {
    return response()->json(['message' => 'Hello World!']);
});
Route::get('events', [FindEventsByDateController::class, 'findEventsByDate']);
Route::post('events/import', [ImportEventsController::class, 'importEvents']);