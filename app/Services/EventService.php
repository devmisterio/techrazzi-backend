<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class EventService
 *
 * Service class for handling logic operations related to events.
 */
class EventService
{
    /**
     * @var EventRepositoryInterface
     */
    protected EventRepositoryInterface $eventRepository;

    /**
     * EventService constructor.
     *
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Get a paginated list of events.
     *
     * @param int $perPage The number of events per page.
     * @param int $page The current page number.
     * @return LengthAwarePaginator|null The paginated list of events, or null if there was an error.
     */
    public function getPaginatedEvents(int $perPage = 5, int $page = 1): ?LengthAwarePaginator
    {
        return $this->eventRepository->getEvents($perPage, $page);
    }

    /**
     * Get an event with its associated details.
     *
     * @param int $eventId The ID of the event to retrieve.
     * @return Event|null The event with its associated details, or null if the event was not found.
     */
    public function getEventDetails(int $eventId): ?Event
    {
        return $this->eventRepository->getEventWithDetails($eventId);
    }

    /**
     * Toggle a user's participation in an event.
     *
     * @param Event $event The event to toggle participation for.
     */
    public function toggleParticipation(Event $event): void
    {
        $user = Auth::user();

        $participation = $user->events()->where('event_id', $event->id)->first();

        if ($participation) {
            $user->events()->detach($event->id);
        } else {
            $user->events()->attach($event->id);
        }
    }

    /**
     * Get all events that a specific user is participating in.
     *
     * @return Collection The collection of events that the user is participating in.
     */
    public function getUserEvents(): Collection
    {
        return $this->eventRepository->getUserEvents(Auth::id());
    }
}
