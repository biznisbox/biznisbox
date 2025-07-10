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

    public function getSupportTickets()
    {
        $supportTickets = self::with('assignee:id,first_name,last_name,email', 'partner', 'category', 'content')->get();
        if ($supportTickets) {
            createActivityLog('retrieve', null, 'App\Models\SupportTicket', 'getSupportTickets');
            return $supportTickets;
        }
        return false;
    }

    public function getSupportTicket($id)
    {
        $supportTicket = self::with(
            'assignee:id,first_name,last_name,email,department_id,position,user_id',
            'partner',
            'category',
            'content'
        )->find($id);
        if ($supportTicket) {
            createActivityLog('retrieve', $id, 'App\Models\SupportTicket', 'getSupportTicket');
            return $supportTicket;
        }
        return false;
    }

    public function createSupportTicket($data)
    {
        $data['number'] = self::getTicketNumber();

        $supportTicket = self::create($data);

        if (isset($data['content'])) {
            foreach ($data['content'] as $content) {
                if ($content['message'] == null) {
                    continue;
                }
                $content['ticket_id'] = $supportTicket->id;
                $content['type'] = 'text';
                $content['status'] = 'sent';
                $content['from'] =
                    $content['from'] ?? auth()->user()->first_name . ' ' . auth()->user()->last_name . ' <' . auth()->user()->email . '>';
                $content['message'] = $content['message'];
                SupportTicketContent::create($content);
            }
        }

        if ($supportTicket) {
            incrementLastItemNumber('support_ticket', settings('support_ticket_number_format'));
            sendWebhookForEvent('support_ticket:created', $supportTicket->toArray());
            return $supportTicket;
        }
        return false;
    }

    public function updateSupportTicket($id, $data)
    {
        $supportTicket = self::find($id);

        if (isset($data['status']) && $data['status'] == 'closed') {
            self::generateSystemMessage($id, 'This ticket has been closed');
        }

        if (isset($data['status']) && $data['status'] == 'reopened') {
            self::generateSystemMessage($id, 'This ticket has been reopened');
        }

        if (isset($data['status']) && $data['status'] == 'resolved') {
            self::generateSystemMessage($id, 'This ticket has been resolved');
        }

        // Clear contact details if custom contact is true
        if ($data['custom_contact'] == true) {
            $data['contact_id'] = null;
            $data['partner_id'] = null;
        }

        // Clear custom contact details if custom contact is false
        if ($data['custom_contact'] == false) {
            $data['contact_name'] = null;
            $data['contact_email'] = null;
            $data['contact_phone_number'] = null;
        }

        $data['number'] = $supportTicket['number'];

        $supportTicket->update($data);

        if ($supportTicket) {
            $supportTicket = $this->getSupportTicket($id);
            sendWebhookForEvent('support_ticket:updated', $supportTicket->toArray());
            return $supportTicket;
        }
        return false;
    }

    public function deleteSupportTicket($id)
    {
        $supportTicket = self::find($id);
        $supportTicket->delete();

        if ($supportTicket) {
            sendWebhookForEvent('support_ticket:deleted', $supportTicket->toArray());
            return $supportTicket;
        }
        return false;
    }

    public static function getTicketNumber()
    {
        $number = generateNextNumber(settings('support_ticket_number_format'), 'support_ticket');
        return $number;
    }

    public function shareTicket($id)
    {
        $ticket = $this->find($id);
        $key = generateExternalKey('support', $ticket->id);
        $url = url('/client/support/' . $id . '?key=' . $key . '&lang=' . app()->getLocale());
        createActivityLog('share', $ticket->id, 'App\Models\SupportTicket', 'shareTicket');
        sendWebhookForEvent('support_ticket:shared', ['id' => $ticket->id, 'url' => $url]);
        return $url;
    }

    public function getClientTicket($id)
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
