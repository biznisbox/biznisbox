<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class SupportTicketContent extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\SupportTicketContent';

    protected $table = 'support_ticket_content';

    protected $fillable = [
        'ticket_id',
        'to',
        'from',
        'status',
        'type',
        'message',
        'subject',
        'message_id',
        'attachment_name',
        'attachment_path',
        'attachment_type',
        'attachment_size',
        'attachment_extension',
        'attachment_mime',
        'attachment_md5',
        'attachment_sha1',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['SupportTicketContent'];
    }

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function getTicketMessages($id)
    {
        $supportTicket = self::where('ticket_id', $id)->get();
        if ($supportTicket) {
            return $supportTicket;
        }
        return false;
    }

    public static function getTicketMessageById($id)
    {
        $supportTicket = self::find($id);
        if ($supportTicket) {
            return $supportTicket;
        }
        return false;
    }

    public function updateTicketMessage($id, $data)
    {
        $content = self::find($id);
        $content->update([
            'to' => $data['to'] ?? null,
            'message' => $data['message'],
            'status' => 'sent',
        ]);

        if ($content) {
            sendWebhookForEvent('support_ticket:message_updated', $content->toArray());
            return $content;
        }
        return false;
    }

    public function deleteTicketMessage($id)
    {
        $content = self::find($id);
        $content->delete();

        if ($content) {
            sendWebhookForEvent('support_ticket:message_deleted', $content->toArray());
            return $content;
        }
        return false;
    }
}
