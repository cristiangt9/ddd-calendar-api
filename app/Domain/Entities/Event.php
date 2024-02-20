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

}