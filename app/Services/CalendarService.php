<?php

namespace App\Services;

use App\Models\CalendarEvent;

class CalendarService
{
    private $calendarEvent;
    public function __construct()
    {
        $this->calendarEvent = new CalendarEvent();
    }

    public function getEvents($user, $start, $end)
    {
        if ($user == null) {
            $user = auth()->id();
        }
        $events = $this->calendarEvent->getEventsByUser($user, $start, $end);
        return $events;
    }

    public function createEvent($data)
    {
        $event = $this->calendarEvent->createEvent($data);
        return $event;
    }

    public function updateEvent($id, $data)
    {
        $event = $this->calendarEvent->updateEvent($id, $data);
        return $event;
    }

    public function deleteEvent($id)
    {
        $event = $this->calendarEvent->deleteEvent($id);
        return $event;
    }

    public function getEvent($id)
    {
        $event = $this->calendarEvent->getEvent($id);
        return $event;
    }
}
