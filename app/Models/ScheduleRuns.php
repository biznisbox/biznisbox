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

    /**
     * Create a new task
     *
     * @param string $task - The task name
     * @param string $status - The status of the task
     * @param string $output - The output of the task (if any)
     * @return void
     */
    public static function createTask($task, $status, $output)
    {
        self::create([
            'task' => $task,
            'status' => $status,
            'output' => $output,
        ]);
    }
}
