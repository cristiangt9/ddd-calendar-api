<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Domain\Services\EventServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Event\CreateEventRequest;
use App\Http\Requests\Api\V1\Event\UpdateEventRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventService;
    private const NOT_FOUND = 'Not found';
    private const EVENT_NOT_FOUND = 'Event not found';

    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }


    public function index(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $events = $this->eventService->getEvents($start, $end);

        return $this->defaultResponse(true, ['events' => $events]);
    }

    public function show($id)
    {
        $event = $this->eventService->findEventById($id);

        if (!$event) {
            return $this->errorResponse(
                self::NOT_FOUND,
                ['message' => self::EVENT_NOT_FOUND],
                404,
                002
            );
        }

        return $this->defaultResponse(true, ['event' => $event->toArray()], 200);
    }

    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated();

        $createdEvent = $this->eventService->createEvent($validatedData);

        if (!$createdEvent) {
            return $this->errorResponse('overlaps', ['message' => 'overlaps'], 422, 007);
        }
        return $this->defaultResponse(true, ['event' => $createdEvent->toArray()], 201);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $validatedData = $request->validated();
        $updatedEvent = $this->eventService->updateEvent($id, $validatedData);

        if (!$updatedEvent) {
            return $this->errorResponse(
                self::NOT_FOUND,
                ['message' => self::EVENT_NOT_FOUND],
                404,
                002
            );
        } else {
            if ($updatedEvent === 'overlap') {
                return $this->errorResponse(
                    'overlaps',
                    ['message' => 'overlaps'],
                    422,
                    007
                );
            }
        }

        return $this->defaultResponse(true, ['event' => $updatedEvent->toArray()],);
    }

    public function destroy($id)
    {
        $result = $this->eventService->deleteEvent($id);

        if (!$result) {
            return $this->errorResponse(
                self::NOT_FOUND,
                ['message' => self::EVENT_NOT_FOUND],
                404,
                002
            );
        }

        return $this->defaultResponse(true, ['message' => 'Event deleted'], 204);
    }
}
