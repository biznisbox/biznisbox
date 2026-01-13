<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SupportTicket extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\SupportTicket';

    protected $fillable = [
        'assignee_id',
        'partner_id',
        'contact_id',
        'category_id',
        'department_id',
        'number',
        'subject',
        'status',
        'priority',
        'type',
        'source',
        'notes',
        'tags',
        'is_internal',
        'channel',
        'custom_contact',
        'contact_name',
        'contact_email',
        'contact_phone_number',
    ];

    protected $casts = [
        'tags' => 'array',
        'custom_contact' => 'boolean',
        'is_internal' => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['SupportTicket'];
    }

    public function assignee()
    {
        return $this->belongsTo(Employee::class, 'assignee_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function contact()
    {
        return $this->belongsTo(PartnerContact::class, 'contact_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function content()
    {
        return $this->hasMany(SupportTicketContent::class, 'ticket_id')->orderBy('created_at', 'asc');
    }

    public static function getTicketNumber()
    {
        return generateNextNumber(settings('support_ticket_number_format'), 'support_ticket');
    }

    public static function getClientTicket($id)
    {
        $ticket = self::with('partner', 'category', 'content', 'department:name,email,phone_number,type,id')->find($id);
        if ($ticket) {
            return $ticket;
        }
        return false;
    }

    protected static function generateSystemMessage($ticket_id, $message)
    {
        SupportTicketContent::create([
            'ticket_id' => $ticket_id,
            'from' => 'system',
            'message' => $message,
            'type' => 'text',
            'status' => 'sent',
        ]);
    }
}
