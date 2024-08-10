<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class CalendarEventAttendee extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'calendar_event_attendees';

    protected $fillable = ['event_id', 'user_id', 'email', 'name', 'status', 'role', 'participation_status', 'rsvp_response', 'comment'];

    protected $hidden = ['created_at', 'updated_at'];

    public function generateTags(): array
    {
        return ['CalendarEventAttendee'];
    }

    public function event()
    {
        return $this->belongsTo(CalendarEvent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value)
    {
        return $this->attributes['status'] = $value ?: 'needs_action';
    }
}
