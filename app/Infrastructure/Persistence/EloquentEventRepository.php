<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Event;
use App\Domain\Repositories\EventRepository;
use App\Infrastructure\Persistence\Models\EloquentEvent;

class EloquentEventRepository implements EventRepository
{

  /**
   * @param int $id
   * @return array
   */
  public function get($start = null, $end = null): array|null
  {
    return EloquentEvent::find();
  }

  /**
   * @param int $id
   * @return Event
   */
  public function findById($id): Event|null
  {
    return EloquentEvent::where(['id' => $id])->first();
  }

  /**
   * @param Event $event
   * @return Event
   */
  public function save(Event $event): Event
  {
    return EloquentEvent::where(['id' => 1])->first();
  }

  /**
   * @param Event $event
   * @return Event
   */
  public function update(Event $event): Event
  {
    return EloquentEvent::where(['id' => 1])->first();
  }

  /**
   * @param Event $event
   * @return bool|null
   */
  public function delete(Event $event): bool|null
  {
    return true;
  }
  
  /**
   * @param Event $event
   * @return bool|null
   */
  public function isOverlaping(Event $event): bool
  {
    return false;
  }
}
