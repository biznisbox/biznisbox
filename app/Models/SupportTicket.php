<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class SupportTicket extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'support_tickets';

    protected $fillable = [
        'assignee_id',
        'partner_id',
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
        return $this->hasMany(SupportTicketContent::class, 'ticket_id');
    }

    public function getSupportTickets()
    {
        $supportTickets = self::with('assignee:id,first_name,last_name,email', 'partner', 'category', 'content')->get();
        if ($supportTickets) {
            activity_log(user_data()->data->id, 'get support tickets', null, 'App\Models\SupportTicket', 'getSupportTickets');
            return $supportTickets;
        }
        return false;
    }

    public function getSupportTicket($id)
    {
        $supportTicket = self::with('assignee', 'partner', 'category', 'content')->find($id);
        if ($supportTicket) {
            activity_log(user_data()->data->id, 'get support ticket', $id, 'App\Models\SupportTicket', 'getSupportTicket');
            return $supportTicket;
        }
        return false;
    }

    public function createSupportTicket($data)
    {
        $supportTicket = self::create($data);

        if (isset($data['content'])) {
            foreach ($data['content'] as $content) {
                $content['ticket_id'] = $supportTicket->id;
                $content['type'] = 'text';
                $content['status'] = 'sent';
                $content['from'] =
                    $content['from'] ??
                    (user_data()->data->first_name . ' ' . user_data()->data->last_name . ' <' . user_data()->data->email . '>' ?? null);
                $content['message'] = $content['message'];
                SupportTicketContent::create($content);
            }
        }

        if ($supportTicket) {
            incrementLastItemNumber('support_ticket');
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

        $supportTicket->update($data);

        if ($supportTicket) {
            return self::with('assignee', 'partner', 'category', 'content')->find($id);
        }
        return false;
    }

    public function deleteSupportTicket($id)
    {
        $supportTicket = self::find($id);
        $supportTicket->delete();

        if ($supportTicket) {
            return $supportTicket;
        }
        return false;
    }

    public function getSupportTicketMessages($id)
    {
        $supportTicket = SupportTicketContent::where('ticket_id', $id)->get();
        if ($supportTicket) {
            return $supportTicket;
        }
        return false;
    }

    public function createSupportTicketMessage($ticket_id, $data)
    {
        $content = new SupportTicketContent();
        $content->ticket_id = $ticket_id;
        $content->to = $data['to'] ?? null;
        $content->from =
            $data['from'] ??
            (user_data()->data->first_name . ' ' . user_data()->data->last_name . ' <' . user_data()->data->email . '>' ?? null);
        $content->message = $data['message'];
        $content->type = 'text';
        $content->status = 'sent';
        $content->save();

        if ($content) {
            return self::with('assignee', 'partner', 'category', 'content')->find($ticket_id);
        }
        return false;
    }

    public function updateSupportTicketMessage($id, $data)
    {
        $content = SupportTicketContent::find($id);
        $content->update($data);

        if ($content) {
            return $content;
        }
        return false;
    }

    public function deleteSupportTicketMessage($id)
    {
        $content = SupportTicketContent::find($id);
        $content->delete();

        if ($content) {
            return $content;
        }
        return false;
    }

    public static function getSupportTicketNumber()
    {
        $number = generate_next_number(settings('support_ticket_number_format'), 'support_ticket');
        return $number;
    }

    public function shareSupportTicket($id)
    {
        $ticket = $this->find($id);
        $key = generate_external_key('support', $ticket->id);
        $url = url('/client/support/' . $id . '?key=' . $key . '&lang=' . app()->getLocale());
        return $url;
    }

    public function getClientTicket($id)
    {
        $ticket = self::with('partner', 'category', 'content')->find($id);
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
