<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CalendarService;

/**
 * @group Calendar
 *
 * APIs for managing calendar events
 */
class CalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Get events
     *
     * @param Request $request
     * @return void
     */
    public function getEvents(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $events = $this->calendarService->getEvents(null, $start, $end);
        if ($events == []) {
            return api_response([], __('responses.data_retrieved_successfully'), 200);
        }
        if (!$events) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($events, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Get event by id
     *
     * @param [type] $id
     * @return void
     */
    public function getEvent($id)
    {
        $event = $this->calendarService->getEvent($id);
        if (!$event) {
            return api_response(null, __('responses.item_not_found_with_id'), 404);
        }
        return api_response($event, __('responses.data_retrieved_successfully'), 200);
    }

    /**
     * Create event
     *
     * @param Request $request
     * @return void
     */
    public function createEvent(Request $request)
    {
        $data = $request->all();
        $event = $this->calendarService->createEvent($data);
        if (!$event) {
            return api_response(null, __('responses.item_not_created'), 400);
        }
        return api_response($event, __('responses.item_created_successfully'), 200);
    }

    /**
     * Update event
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function updateEvent(Request $request, $id)
    {
        $data = $request->all();
        $event = $this->calendarService->updateEvent($id, $data);
        if (!$event) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($event, __('responses.item_updated_successfully'), 200);
    }

    /**
     * Delete event
     *
     * @param [type] $id
     * @return void
     */
    public function deleteEvent($id)
    {
        $event = $this->calendarService->deleteEvent($id);
        if (!$event) {
            return api_response(null, __('responses.item_not_deleted'), 400);
        }
        return api_response($event, __('responses.item_deleted_successfully'), 200);
    }
}
