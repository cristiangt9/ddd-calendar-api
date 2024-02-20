<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Domain\Services\EventServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Event\CreateEventRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventService;
    private const EVENT_NOT_FOUND = 'event_not_found';

    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    
    public function index(Request $request): JsonResponse
    {
        $start = $request->input('start');
        $end = $request->input('end');
        
        $events = $this->eventService->getEvents($start, $end);

        return response()->json(['events' => $events], 200);
    }

    public function show($id): JsonResponse
    {
        $event = $this->eventService->findEventById($id);

        if (!$event) {
            return response()->json(['message' => self::EVENT_NOT_FOUND], 404);
        }

        return response()->json(['event' => $event->toArray()]);
    }

    public function store(CreateEventRequest $request)
    {
        $validatedData = $request->validated(); // Obtiene los datos validados

        $createdEvent = $this->eventService->createEvent($validatedData);

        if (!$createdEvent) {
            return response()->json(['message' => 'overlaps'], 422);
        }
        return response()->json(['event' => $createdEvent->toArray()], 201);
        //TODO: estandarizar la respuesta con un trait

    }

    public function update($request, $id): JsonResponse
    {
        $validatedData = $request->validated(); // Obtiene los datos validados
        $updatedEvent = $this->eventService->updateEvent($id, $validatedData);

        if (!$updatedEvent) {
            return response()->json(['message' => self::EVENT_NOT_FOUND], 404);
        } else {
            if ($updatedEvent === 'overlap') {
                return response()->json(['message' => 'overlaps'], 422);
            }
        }

        return response()->json(['event' => $updatedEvent->toArray()]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->eventService->deleteEvent($id);

        if (!$result) {
            return response()->json(['message' => self::EVENT_NOT_FOUND], 404);
        }

        return response()->json(['message' => 'Event deleted'], 204);
    }
}
