<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ScheduleRuns extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'schedule_runs';

    protected $fillable = ['task', 'status', 'output', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public static function createTask($task, $status, $output)
    {
        $task = new ScheduleRuns();
        $task->task = $task;
        $task->status = $status;
        $task->output = $output;
        $task->save();
    }
}
