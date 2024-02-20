<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentEvent extends Model {

  use HasFactory;

  protected $table = "events";
  
  protected $fillable = [
    'title',
    'description',
    'start',
    'end',
    'frequency',
    'repeat_until',
    'original_event_id'
  ];
}
