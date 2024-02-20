<?php

namespace App\Domain\Entities;

class Event
{
  private $id;
  private $title;
  private $description;
  private $start;
  private $end;
  private $frequency;
  private $repeat_until;
  private $original_event_id;

  public function __construct(
    $title,
    $description,
    $start,
    $end,
    $frequency = null,
    $repeat_until = null,
    $original_event_id = null,
  ) {
    $this->id = null;
    $this->title = $title;
    $this->description = $description;
    $this->start = $start;
    $this->end = $end;
    $this->frequency = $frequency;
    $this->repeat_until = $repeat_until;
    $this->original_event_id = $original_event_id;
  }
  // setters and getters
  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }

  public function getTitle()
  {
    return $this->title;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function setDescription($description)
  {
    $this->description = $description;
  }
  public function getStart()
  {
    return $this->start;
  }
  public function setStart($start)
  {
    $this->start = $start;
  }
  public function getEnd()
  {
    return $this->end;
  }
  public function setEnd($end)
  {
    $this->end = $end;
  }
  public function getFrequency()
  {
    return $this->frequency;
  }
  public function setFrequency($frequency)
  {
    $this->frequency = $frequency;
  }
  public function getRepeatUntil()
  {
    return $this->repeat_until;
  }
  public function setRepeatUntil($repeat_until)
  {
    $this->repeat_until = $repeat_until;
  }
  public function getOriginalEvent()
  {
    return $this->original_event_id;
  }
  public function setOriginalEvent($original_event_id)
  {
    $this->original_event_id = $original_event_id;
  }

  public function toArray()
  {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'start' => $this->start,
      'end' => $this->end,
      'frequency' => $this->frequency,
      'repeat_until' => $this->repeat_until,
      'original_event_id' => $this->original_event_id,
    ];
  }
}
