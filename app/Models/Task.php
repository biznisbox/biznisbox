<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Task';

    protected $table = 'tasks';
    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'number',
        'type',
        'category',
        'notes',
        'progress_in_percent',
        'tags',
        'description',
        'start_date',
        'due_date',
        'completed_at',
        'status',
        'priority',
        'active',
    ];

    protected $dates = ['start_date', 'due_date', 'completed_at', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function generateTags(): array
    {
        return ['Task'];
    }

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'start_date' => 'datetime',
            'due_date' => 'datetime',
            'completed_at' => 'datetime',
            'progress_in_percent' => 'integer',
            'active' => 'boolean',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public static function generateTaskNumber($projectId)
    {
        $project = Project::firstWhere('id', $projectId);
        if (!$project) {
            return null; // or throw an exception if preferred
        }

        Log::info($project);

        return generateProjectTaskNumber($project->project_key);
    }
}
