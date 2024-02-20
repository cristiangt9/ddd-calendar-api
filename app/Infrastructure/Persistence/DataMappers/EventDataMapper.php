<?php

namespace App\Infrastructure\Persistence\DataMappers;

use App\Domain\Entities\Event;
use App\Infrastructure\Persistence\Models\EloquentEvent;
use Illuminate\Database\Eloquent\Collection;

class EventDataMapper
{
  public function mapToEntity(EloquentEvent $eloquentEvent): Event
  {
    $new_event = new Event(
      $eloquentEvent->title,
      $eloquentEvent->description,
      $eloquentEvent->start,
      $eloquentEvent->end,
      $eloquentEvent->frequency,
      $eloquentEvent->repeat_until,
      $eloquentEvent->original_event_id,
    );
    if($eloquentEvent->id) {
      $new_event->setId($eloquentEvent->id);
    }
    return $new_event;
  }

  public function mapToEloquent(Event $event): EloquentEvent
  {
    return EloquentEvent::create($event->toArray());
  }

  public function mapToEntities(Collection $events): array
  {
    $eventsArray = [];
    foreach ($events as $event) {
      $eventsArray[] = $this->mapToEntity($event);
    }
    return $eventsArray;
  }
}
