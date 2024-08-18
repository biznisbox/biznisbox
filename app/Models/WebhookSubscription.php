<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class WebhookSubscription extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'url',
        'signature_secret_key',
        'is_active',
        'listen_events',
        'http_verb',
        'headers',
        'notes',
        'last_called_at',
        'can_be_edited',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'can_be_edited' => 'boolean',
    ];

    protected static function booted()
    {
        self::saving(function ($model) {
            if (empty($model->signature_secret_key)) {
                $model->signature_secret_key = Str::random(64);
            }
        });
    }

    protected function listenEvents(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => is_string($value) ? array_map('trim', explode(',', $value)) : [],
            set: fn(string|array|null $value) => is_array($value) ? implode(',', $value) : $value
        );
    }

    protected function headers(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => is_string($value) ? json_decode($value, true) : [],
            set: fn(array|string|null $value) => is_array($value) ? json_encode($value) : $value
        );
    }

    public function isListenFor(string $event): bool
    {
        if ($this->isListenForAnyEvent()) {
            return true;
        }

        return in_array($event, $this->listen_events);
    }

    public function isListenForAnyEvent(): bool
    {
        return in_array('*', $this->listen_events);
    }

    public function signPayload(array $payload): string
    {
        return hash_hmac('sha256', json_encode($payload), $this->signature_secret_key);
    }
}
