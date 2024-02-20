<?php

namespace App\Application\Services;

use App\Domain\Entities\Event;
use App\Domain\Repositories\EventRepository;
use App\Domain\Services\EventServiceInterface;



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
    if ($this->eventRepository->isOverlaping($event)) {
      return false;
    }

    if (array_key_exists("recurring_pattern", $validatedData)) {
      $event->setFrequency($validatedData["recurring_pattern"]["frequency"]);
      $event->setRepeatUntil($validatedData["recurring_pattern"]["repeat_until"]);
      // TODO: send to create in mass, for daily, weekly, monthly, or yearly
    }
    return $this->eventRepository->save($event);
  }

  public function updateEvent($id, $validatedData): Event|bool|string
  {

    return $this->eventRepository->findById($id);
  }

  public function deleteEvent($id): bool
  {
    return true;
  }

  public function findEventById($id): Event|null
  {
    return $this->eventRepository->findById($id);
  }

  public function getEvents($start = null, $end = null): array|null
  {
    return [];
  }

}
