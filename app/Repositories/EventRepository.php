<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class EventRepository
 *
 * Repository for handling database operations related to events.
 */
class EventRepository implements EventRepositoryInterface
{
    /**
     * Get a paginated list of events.
     *
     * @param int $perPage The number of events per page.
     * @param int $page The current page number.
     * @return LengthAwarePaginator|null The paginated list of events, or null if there was an error.
     */
    public function getEvents(int $perPage = 5, int $page = 1): ?LengthAwarePaginator
    {
        try {
            return DB::table("events")
                ->leftJoin("venues", "events.venue_id", "=", "venues.id")
                ->select(
                    "events.id",
                    "events.name",
                    "events.description",
                    "events.list_image",
                    "events.start_date",
                    "events.venue_id",
                    "venues.city",
                    "events.is_online",
                    DB::raw(
                        "IF(events.participant_limit IS NOT NULL AND (SELECT COUNT(*) FROM event_user WHERE event_user.event_id = events.id) >= events.participant_limit, 1, 0) AS is_participant_limit_reached"
                    )
                )
                ->orderBy("events.start_date", "asc")
                ->paginate(perPage: $perPage, page: $page);
        } catch (QueryException $e) {
            Log::error('Error fetching events: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Get an event with its associated details.
     *
     * @param int $eventId The ID of the event to retrieve.
     * @return Event|null The event with its associated details, or null if the event was not found.
     */
    public function getEventWithDetails(int $eventId): ?Event
    {
        try {
            return Event::where("id", $eventId)
                ->with(["venue", "comments.user", "participants", "talks.speakers"])
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Log::error('Event not found: ' . $e->getMessage());

            return null;

        }
    }

    /**
     * Get all events that a specific user is participating in.
     *
     * @param int $userId The ID of the user.
     * @return Collection The collection of events that the user is participating in.
     */
    public function getUserEvents(int $userId): Collection
    {
        try {
            return Event::whereHas("participants", function (Builder $query) use ($userId) {
                $query->where("user_id", '=', $userId);
            })->get();
        } catch (\Exception $e) {
            Log::error('Error fetching user events: ' . $e->getMessage());
            return collect([]);
        }
    }
}
