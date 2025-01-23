<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class CalendarEvent extends Model implements Auditable
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
        'timezone',
        'all_day',
        'rrule',
        'location',
        'reminder',
        'show_as',
        'status',
        'privacy',
    ];

    protected function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
            'all_day' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['CalendarEvent'];
    }

    protected $dates = ['deleted_at', 'updated_at', 'created_at, start, end'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendees()
    {
        return $this->hasMany(CalendarEventAttendee::class, 'event_id');
    }

    public function getColorAttribute($value)
    {
        return $this->attributes['color'] = $value ? '#' . $value : null;
    }

    public function setColorAttribute($value)
    {
        $this->attributes['color'] = $value ? str_replace('#', '', $value) : null;
    }

    /**
     * Get all events
     * @param string $user_id
     * @param string $start
     * @param string $end
     * @return array
     */
    public function getEventsByUser($user_id = null, $start = null, $end = null)
    {
        if ($user_id == null) {
            $user_id = auth()->id();
        }
        $all_events = [];
        $query = $this->where('user_id', $user_id);
        if ($start != null || $end != null) {
            $query->whereBetween('start', [$start, $end]);
        }
        $events = $query->get();
        foreach ($events as $event) {
            $all_events[] = self::eventFormat($event);
        }
        createActivityLog('retrieve', null, 'App\Models\CalendarEvent', 'CalendarEvent');
        return $all_events;
    }

    /**
     * Create an event
     * @param array $data
     * @return object
     */
    public function createEvent($data)
    {
        $data['user_id'] = auth()->id();

        $event = $this->create($data);

        if (isset($data['attendees'])) {
            $event->attendees()->createMany($data['attendees']);
        }
        return $event;
    }

    /**
     * Update an event
     * @param array $data
     * @param string $id
     * @return object
     */
    public function updateEvent($id, $data)
    {
        $event = $this->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
        $event->update($data);

        if (isset($data['attendees'])) {
            $event->attendees()->delete();
            $event->attendees()->createMany($data['attendees']);
        }
        return $event;
    }

    /**
     * Delete an event
     * @param string $id
     * @return object
     */
    public function deleteEvent($id)
    {
        $event = $this->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
        $event->attendees()->delete();
        $event->delete();
        return $event;
    }

    /**
     * Get a single event
     * @param string $id
     * @return object
     */
    public function getEvent($id)
    {
        $event = $this->where('user_id', auth()->id())
            ->where('id', $id)
            ->with('attendees')
            ->firstOrFail();
        createActivityLog('retrieve', $event->id, 'App\Models\CalendarEvent', 'CalendarEvent');
        return $event;
    }

    /**
     * Format the event data -> FullCalendar
     * @param object $data
     * @return void
     */
    private function eventFormat($data)
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
