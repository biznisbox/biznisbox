<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin\UserDetails;

class User extends Authenticatable implements JWTSubject, Auditable
{
    use HasFactory, Notifiable, SoftDeletes, HasUuids, HasRoles;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'active',
        'picture',
        'last_login_at',
        'language',
        'timezone',
        'theme',
        'oauth_user',
        'two_factor_auth',
    ];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at', 'password', 'oauth_user', 'remember_token'];

    protected $appends = ['full_name', 'avatar_url', 'role'];

    protected $dates = ['deleted_at', 'updated_at', 'created_at', 'last_login_at'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'two_factor_auth' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['User'];
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the full name attribute.
     * @return string
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn(mixed $value, array $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name']);
    }

    protected function AvatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['picture'] ? asset('storage/' . $attributes['picture']) : null
        );
    }

    protected function Role(): Attribute
    {
        return Attribute::make(get: fn(mixed $value, array $attributes) => $this->getRoleNames()->toArray()[0] ?? null);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'data' => [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'picture' => $this->picture,
                'language' => $this->language,
                'timezone' => $this->timezone,
                'theme' => $this->theme,
                'permissions' => $this->getPermissionsViaRoles()->pluck('name')->toArray(),
                'roles' => $this->getRoleNames()->toArray(),
                'avatar_url' => $this->avatar_url,
            ],
        ];
    }

    /**
     * Get public users.
     */
    public function getPublicUsers()
    {
        $users = $this->where('active', true)->get(['id', 'first_name', 'last_name', 'email', 'picture', 'language', 'timezone']);
        createActivityLog('retrievePublic', null, 'App\Models\User', 'User');
        return $users;
    }

    /**
     * Get all users.
     * @return string
     */
    public function getUsers()
    {
        $users = $this->with('roles')->get();
        if ($users) {
            return $users;
        }
        return false;
    }

    public function getUser($id)
    {
        $user = $this->with('roles', 'permissions', 'sessions')->find($id);
        if ($user) {
            return $user;
        }
        return false;
    }

    public function createUser($data)
    {
        if ($this->checkIfUserExists($data['email'])) {
            return false;
        }

        $user = $this->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => $data['active'],
            'language' => $data['language'] ?? 'en',
            'timezone' => $data['timezone'] ?? 'UTC',
            'two_factor_auth' => false,
        ]);

        if ($user) {
            $this->generateUserAvatar($user->id, $data['first_name'], $data['last_name']);
            $user->assignRole($data['role']);
            if (isset($data['send_details_to'])) {
                $this->sendUserDetailsEmail($data['send_details_to'], $user->id, $data['password']);
            }

            return true;
        }
        return false;
    }

    private function checkIfUserExists($email)
    {
        $user = $this->where('email', $email)->first();
        if ($user) {
            return true;
        }
        return false;
    }

    public function updateUser($id, $data)
    {
        $user = $this->find($id);

        if ($user->email !== $data['email'] && $this->checkIfUserExists($data['email'])) {
            return false;
        }

        if ($user) {
            // Check if role has changed
            if ($data['role'] != $user->role) {
                createActivityLog('roleChange', $user->id, 'App\Models\User', 'User');
            }
            $user->syncRoles($data['role']);
            $user->update([
                'first_name' => $data['first_name'] ?? $user->first_name,
                'last_name' => $data['last_name'] ?? $user->last_name,
                'email' => $data['email'] ?? $user->email,
                'active' => $data['active'] ?? $user->active,
                'language' => $data['language'] ?? $user->language,
                'timezone' => $data['timezone'] ?? $user->timezone,
            ]);
            $user->update();

            return true;
        }
        return false;
    }

    public function resetPassword($id, $data)
    {
        $user = $this->find($id);
        if ($user) {
            $user->update([
                'password' => $data['password'],
            ]);

            if (isset($data['send_details_to'])) {
                $this->sendUserDetailsEmail($data['send_details_to'], $user->id, $data['password']);
            }

            return true;
        }
        return false;
    }

    public function deleteUser($id)
    {
        // Prevent deleting own account
        if ($id == auth()->user()->id) {
            return false;
        }

        $user = $this->find($id);
        if ($user) {
            $user->syncRoles([]);
            $user->update([
                'email' => null,
                'password' => null,
                'active' => false,
                'deleted_at' => now(),
            ]);
            return true;
        }
        return false;
    }

    public function generateUserAvatar($user_id, $first_name, $last_name)
    {
        $avatar = new Avatar([
            'width' => 300,
            'height' => 300,
            'quality' => 90,
            'format' => 'png',
            'type' => 'square',
            'backgrounds' => [
                '#f44336',
                '#E91E63',
                '#9C27B0',
                '#673AB7',
                '#3F51B5',
                '#2196F3',
                '#03A9F4',
                '#00BCD4',
                '#009688',
                '#4CAF50',
                '#8BC34A',
                '#CDDC39',
                '#FFC107',
                '#FF9800',
                '#FF5722',
            ],
            'fontSize' => 120,
            'font_color' => '#ffffff',
        ]);
        $img_path = $user_id . '.png';
        $avatar->create($first_name . ' ' . $last_name)->save(storage_path('/app/public/' . $img_path));
        return $this->find($user_id)->update(['picture' => $img_path]);
    }

    public function sendUserDetailsEmail($recipient, $user_id, $password = null)
    {
        $user = $this->find($user_id);
        if ($user) {
            foreach ($recipient as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($email)->send(new UserDetails($user, $password));
                }
            }
            return true;
        }
        return false;
    }
}
