<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Hash;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes, HasRoles;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'users';

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'active', 'picture', 'role', 'last_login_at', 'language'];

    protected $hidden = ['password'];

    protected $casts = [
        'active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function generateTags(): array
    {
        return ['User'];
    }

    public function sessions()
    {
        return $this->hasMany(Sessions::class, 'user_id');
    }

    /**
     * Function return user initials
     * @return string
     */
    public function getInitials()
    {
        return $this->first_name[0] ?? ('' . $this->last_name[0] ?? '');
    }

    public function getPictureAttribute($value)
    {
        if ($value) {
            return url('storage/avatars/' . $value);
        }
        return null;
    }

    /**
     * Function update user last login time
     * @return void
     */
    public function updateLastLogin()
    {
        $this->last_login_at = now();
        $this->update();
    }

    public function getUsers()
    {
        return $this->all();
    }

    public function getUser($id)
    {
        $user = $this->find($id);
        if ($user) {
            $user->sessions = $user->sessions()->get();
            return $user;
        }
        return null;
    }

    public function createUser($data)
    {
        $user = $this->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'active' => $data['active'],
            'role' => $data['role'],
            'language' => $data['language'],
        ]);
        if ($user) {
            $user->assignRole($data['role']);
            return true;
        }
        return false;
    }

    public function checkIfUserExists($email)
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
        if ($user) {
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->active = $data['active'];
            $user->role = $data['role'];
            $user->update();
            $user->syncRoles($data['role']);
            return true;
        }
        return false;
    }

    public function resetPassword($id, $password)
    {
        $user = $this->find($id);
        if ($user) {
            $user->password = Hash::make($password);
            $user->update();
            return true;
        }
        return false;
    }

    public function deleteUser($id)
    {
        $user = $this->find($id);
        if ($user) {
            $user->syncRoles([]);
            $user->password = null;
            $user->active = false;
            $user->email = null;
            $user->save();
            $user->delete();
            return true;
        }
        return false;
    }

    public function getPublicUsers()
    {
        $users = $this->select('id', 'first_name', 'last_name', 'picture', 'email')->get();
        foreach ($users as $user) {
            $user->label = $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')';
        }
        return $users;
    }
}
