<?php

namespace App\Domain\Services;

use App\Domain\Entities\Event;

interface EventServiceInterface
{
    public function createEvent($validatedData): Event|bool;

    public function updateEvent($id, $validatedData): Event|bool|string;

    public function deleteEvent($id): bool;

    public function findEventById($id): Event|bool;

    public function getEvents($start = null, $end = null): array|null;

}
