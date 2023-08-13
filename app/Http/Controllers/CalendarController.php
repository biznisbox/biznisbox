<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvents;

class CalendarController extends Controller
{
    private $calendarModel;
    public function __construct(CalendarEvents $calendarModel)
    {
        $this->calendarModel = $calendarModel;
    }

    public function createEvent(Request $request)
    {
        $data = $request->all();
        $event = $this->calendarModel->createEvent($data);

        if (!$event) {
            return api_response(null, __('response.calendar.create_failed'), 500);
        }
        return api_response($event, __('response.calendar.create_success'));
    }

    public function updateEvent(Request $request, $event_id)
    {
        $data = $request->all();
        $event = $this->calendarModel->updateEvent($event_id, $data);
        if (!$event) {
            return api_response(null, __('response.calendar.update_failed'), 500);
        }
        return api_response($event, __('response.calendar.update_success'));
    }

    public function deleteEvent(Request $request, $event_id)
    {
        $event = $this->calendarModel->deleteEvent($event_id);
        if (!$event) {
            return api_response(null, __('response.calendar.delete_failed'), 500);
        }
        return api_response($event, __('response.calendar.delete_success'));
    }

    public function getEvent(Request $request, $event_id)
    {
        $event = $this->calendarModel->getEvent($event_id);
        if (!$event) {
            return api_response(null, __('response.calendar.get_error'), 500);
        }
        return api_response($event, __('response.calendar.get_success'));
    }

    public function getUserEvents(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $events = $this->calendarModel->getEventsByUser($start, $end);
        return api_response($events, __('response.calendar.get_success'));
    }
}
