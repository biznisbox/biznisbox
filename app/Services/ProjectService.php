<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;

class ProjectService
{
    private $projectModel;
    private $taskModel;

    public function __construct()
    {
        $this->projectModel = new Project();
        $this->taskModel = new Task();
    }

    public function getProjectsForUser()
    {
        $userId = auth()->id();
        return $this->projectModel
            ->with('partner', 'creator:id,email,first_name,last_name,picture', 'members')
            ->where('created_by', $userId)
            ->orWhereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
    }

    public function getProjectById($id)
    {
        $userId = auth()->id();
        return $this->projectModel
            ->with('tasks', 'partner', 'creator', 'members:id,email,first_name,last_name,picture')
            ->where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('created_by', $userId)->orWhereHas('members', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->firstOrFail();
    }

    public function createProject($data)
    {
        $data['created_by'] = auth()->id();
        $data['number'] = Project::getProjectNumber();
        if (!isset($data['is_billable'])) {
            $data['is_billable'] = false;
        }
        // Add created by user as a member (owner)
        $project = $this->projectModel->create($data);
        $project->members()->attach($data['created_by'], ['role' => 'owner', 'id' => uuid_create()]);
        return $project;
    }

    public function updateProject($id, $data)
    {
        $project = $this->getProjectById($id);
        if (!isset($data['is_billable'])) {
            $data['is_billable'] = false;
        }
        $project->update($data);
        return $project;
    }

    public function deleteProject($id)
    {
        $project = $this->getProjectById($id);
        return $project->delete();
    }

    // Task related methods

    public function getTaskById($id)
    {
        $task = $this->taskModel->with('assignee:id,email,first_name,last_name,picture', 'project')->findOrFail($id);
        return $task;
    }

    public function createTask($data)
    {
        $data['number'] = Task::generateTaskNumber([$data['project_id']]);
        $task = $this->taskModel->create($data);
        return $task;
    }

    public function updateTask($id, $data)
    {
        $task = $this->taskModel->findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function deleteTask($id)
    {
        $task = $this->taskModel->findOrFail($id);
        return $task->delete();
    }
}
