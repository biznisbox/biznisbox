<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class CalendarEvents extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'calendar_events';
    protected $fillable = [
        'user_id',
        'title',
        'icon',
        'type',
        'color',
        'description',
        'start',
        'end',
        'all_day',
        'timezone',
        'rrule',
        'location',
        'reminder',
        'show_as',
        'status',
        'privacy',
    ];
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'all_day' => 'boolean',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['CalendarEvents'];
    }

    public function getColorAttribute($value)
    {
        return $this->attributes['color'] = $value ? '#' . $value : null;
    }

    public function setColorAttribute($value)
    {
        $this->attributes['color'] = $value ? str_replace('#', '', $value) : null;
    }

    public function createEvent($data)
    {
        $data['user_id'] = user_data()->data->id;
        $event = $this->create($data);
        return $event;
    }

    public function updateEvent($id, $data)
    {
        $event = $this->where('id', $id)
            ->where('user_id', user_data()->data->id)
            ->firstOrFail();
        $event->update($data);
        return $event;
    }

    public function deleteEvent($event_id)
    {
        $event = $this->where('id', $event_id)
            ->where('user_id', user_data()->data->id)
            ->firstOrFail();
        $event->delete();
        return $event;
    }

    public function getEvent($event_id)
    {
        $event = $this->where('id', $event_id)
            ->where('user_id', user_data()->data->id)
            ->firstOrFail();
        activity_log(user_data()->data->id, 'get event', $event_id, 'App\Models\CalendarEvents', 'getEvent');
        return $event;
    }

    public function getEventsByUser($start, $end)
    {
        $all_events = [];
        $events = $this->where('user_id', user_data()->data->id)
            ->where('start', '>=', $start)
            ->where('end', '<=', $end)
            ->get();
        foreach ($events as $event) {
            $all_events[] = self::eventFormat($event);
        }
        activity_log(user_data()->data->id, 'get events by user', user_data()->data->id, 'App\Models\CalendarEvents', 'getEventsByUser');
        return $all_events;
    }

    public function getEventsByDate($calendar_id, $start, $end)
    {
        $events = $this->where('calendar_id', $calendar_id)
            ->where('start', '>=', $start)
            ->where('end', '<=', $end)
            ->get();
        activity_log(user_data()->data->id, 'get events by date', $calendar_id, 'App\Models\CalendarEvents', 'getEventsByDate');
        return $events;
    }

    public function eventFormat($data)
    {
        $event = [];
        $event['id'] = $data->id;
        $event['title'] = $data->title;
        $event['start'] = $data->start;
        $event['end'] = $data->end;
        $event['allDay'] = $data->all_day;
        $event['description'] = $data->description;
        $event['color'] = $data->color;
        $event['rrule'] = $data->rrule;
        return $event;
    }
}
