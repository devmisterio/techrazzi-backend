<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventIndexRequest;
use App\Http\Resources\EventDetailResource;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EventController
 *
 * Controller for handling event related requests.
 */
class EventController extends Controller
{
    /**
     * @var EventService
     */
    protected EventService $eventService;

    /**
     * EventController constructor.
     *
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a paginated list of events.
     *
     * @param EventIndexRequest $request
     * @return JsonResource
     */
    public function index(EventIndexRequest $request): JsonResource
    {
        $validated = $request->validated();

        $perPage = $validated['perPage'] ?? config('event.pagination.default_per_page');
        $page = $validated['page'] ?? config('event.pagination.default_page');

        $events = $this->eventService->getPaginatedEvents($perPage, $page);

        return EventResource::collection($events);
    }

    /**
     * Display the specified event.
     *
     * @param int $eventId
     * @return EventDetailResource|JsonResponse
     */
    public function show(int $eventId): EventDetailResource|JsonResponse
    {
        $eventDetails = $this->eventService->getEventDetails($eventId);

        if (is_null($eventDetails)) {
            return response()->json(['message' => 'Event not found.'], Response::HTTP_NOT_FOUND);
        }

        return new EventDetailResource($eventDetails);
    }

    /**
     * Toggle a user's participation in an event.
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function toggleParticipation(Event $event): JsonResponse
    {
        $this->eventService->toggleParticipation($event);

        return response()->json(['success' => true ], Response::HTTP_OK);
    }

    /**
     * Display a list of events that the authenticated user is participating in.
     *
     * @return JsonResource
     */
    public function userEvents(): JsonResource
    {
        $events = $this->eventService->getUserEvents();

        return EventResource::collection($events);
    }
}
