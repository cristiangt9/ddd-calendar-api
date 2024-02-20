<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Event;

interface EventRepository
{
  public function get($start = null, $end = null): array|null;
  public function findById($id): Event|null;

  public function save(Event $event): Event;

  public function update(Event $event): Event;

  public function delete(Event $event): bool|null;

  public function isOverlaping(Event $event): bool;
}
