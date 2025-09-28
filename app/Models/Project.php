<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Project';

    protected $table = 'projects';
    protected $fillable = [
        'created_by',
        'project_key',
        'number',
        'partner_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'priority',
        'budget',
        'is_billable',
        'active',
    ];

    protected $dates = ['start_date', 'end_date', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function generateTags(): array
    {
        return ['Project'];
    }

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_billable' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'user_id')->withTimestamps();
    }

    public static function getProjectNumber()
    {
        return generateNextNumber(settings('project_number_format'), 'project');
    }
}
