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

    protected $table = 'support_ticket_content';

    protected $fillable = [
        'ticket_id',
        'status',
        'type',
        'message',
        'subject',
        'message_id',
        'from',
        'to',
        'attachment_name',
        'attachment_path',
        'attachment_type',
        'attachment_size',
        'attachment_extension',
        'attachment_mime',
        'attachment_url',
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
}
