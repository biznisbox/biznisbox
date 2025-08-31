<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Notification extends Model
{
    use HasFactory, HasUuids;

    public static $modelName = 'App\Models\Notification';

    protected $fillable = ['user_id', 'title', 'content', 'type', 'is_read', 'action_text', 'action_url'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->save();
    }

    public function createNotification($user_id, $title, $content, $type = 'info', $action_text = null, $action_url = null)
    {
        return $this->create([
            'user_id' => $user_id ?? null,
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'action_text' => $action_text,
            'action_url' => $action_url,
        ]);
    }

    public static function getUserNotifications($user_id)
    {
        return self::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
    }
}
