<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class PersonalAccessToken extends Model implements Auditable
{
    use HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\PersonalAccessToken';

    protected $table = 'personal_access_tokens';

    protected $fillable = ['user_id', 'name', 'token', 'type', 'active', 'last_used_at', 'valid_until'];

    protected $hidden = ['updated_at', 'token'];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'valid_until' => 'datetime',
        ];
    }

    public function generateTags(): array
    {
        return ['PersonalAccessToken'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPersonalAccessTokens($userId)
    {
        return $this->where('user_id', $userId)->get();
    }

    public function getPersonalAccessToken($id)
    {
        return $this->find($id);
    }
}
