<?php

namespace App\Application\Services;

use App\Domain\Entities\Event;
use App\Domain\Repositories\EventRepository;
use App\Domain\Services\EventServiceInterface;
use Carbon\Carbon;

class EventService implements EventServiceInterface
{
  private $eventRepository;

  public function __construct(EventRepository $eventRepository)
  {
    $this->eventRepository = $eventRepository;
  }

  public function createEvent($validatedData): Event|bool
  {

    $event = new Event(
      $validatedData["title"],
      $validatedData["description"],
      $validatedData["start"],
      $validatedData["end"]
    );
    //validar si hay colision
    if ($this->eventRepository->isOverlapping($event)) {
      return false;
    }

    if (array_key_exists("recurring_pattern", $validatedData)) {
      $event->setFrequency($validatedData["recurring_pattern"]["frequency"]);
      $event->setRepeatUntil($validatedData["recurring_pattern"]["repeat_until"]);
      return $this->createFrequentEvent($event);
    }
    return $this->eventRepository->save($event);
  }

  public function updateEvent($id, $validatedData): Event|bool|string
  {
    $event = $this->eventRepository->findById($id);
    if (is_null($event)) {
      return false;
    }
    foreach ($validatedData as $key => $value) {
      $getter = 'set' . str_replace('_', '', ucwords($key, '_'));
      $event->{$getter}($value);
    }
    if ($this->eventRepository->isOverlapping($event)) {
      return 'overlap';
    }
    return $this->eventRepository->update($event);
  }

  public function deleteEvent($id): bool
  {
    $event = $this->eventRepository->findById($id);
    if (is_null($event)) {
      return false;
    }
    return $this->eventRepository->delete($event);
  }

  public function findEventById($id): Event|null
  {
    return $this->eventRepository->findById($id);
  }

  public function getEvents($start = null, $end = null): array|null
  {
    $result = $this->eventRepository->get($start, $end);
    if (is_array($result)) {
      $array = [];
      foreach ($result as $value) {
        $array[] = $value->toArray();
      }
      return $array;
    }
    return $result;
  }

  // private methods
  private function createFrequentEvent(Event $event)
  {
    $event = $this->eventRepository->save($event);
    $frecuency = [
      'daily' => 'addDays',
      'weekly' => 'addWeeks',
      'monthly' => 'addMonths',
      'yearly' => 'addYears',
    ];
    $i = 1;
    $frecuencyFunction = $frecuency[$event->getFrequency()];

    $start = $this->createDate($event->getStart(), $frecuencyFunction, $i);
    $end = $this->createDate($event->getEnd(), $frecuencyFunction, $i);

    while ($start < $event->getRepeatUntil()) {
      $newEvent = new Event(
        $event->getTitle(),
        $event->getDescription(),
        $start,
        $end
      );
      $newEvent->setOriginalEvent($event->getId());
      $this->eventRepository->save($newEvent);
      $i++;
      $start = $this->createDate($event->getStart(), $frecuencyFunction, $i);
      $end = $this->createDate($event->getEnd(), $frecuencyFunction, $i);
    }

    return $event;
  }

  private function createDate($date, $frecuencyFunction, $i): string
  {
    return Carbon::parse($date)->{$frecuencyFunction}($i)->format('Y-m-d\TH:i:sP');
  }
}
