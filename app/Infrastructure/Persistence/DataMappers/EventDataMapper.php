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
      $eloquentEvent->repeat_until
    );
    if($eloquentEvent->id) {
      $new_event->setId($eloquentEvent->id);
    }
    return $new_event;
  }

  public function mapToEloquent(Event $event): EloquentEvent
  {
    $values = [
      'title' => $event->getTitle(),
      'description' => $event->getDescription(),
      'start' => $event->getStart(),
      'end' => $event->getEnd(),
      'frequency' => $event->getFrequency(),
      'repeat_until' => $event->getRepeatUntil(),
    ];
    if($event->getId()) {
      $values = array_merge($values, ['id' => $event->getId()]);
    }
  
    return EloquentEvent::create($values);
  }
}
