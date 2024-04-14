<?php

namespace App\Interfaces;

interface EventRepositoryInterface
{
    public function getEvents(int $perPage = 5, int $page = 1);
    public function getEventWithDetails(int $eventId);
    public function getUserEvents(int $userId);
}
