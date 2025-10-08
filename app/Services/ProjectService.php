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
        $project->members()->attach($data['created_by'], ['project_role' => 'owner', 'id' => uuid_create()]);
        incrementLastItemNumber('project', settings('project_number_format'));
        return $project;
    }

    public function updateProject($id, $data)
    {
        $project = $this->getProjectById($id);
        $data['project_key'] = $project->project_key; // Prevent updating project_key
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

    /**********************************
     **** Project Member methods ******
     **********************************/
    public function addProjectMember($projectId, $userId, $role = 'member')
    {
        $project = $this->getProjectById($projectId);
        if ($project->members()->where('user_id', $userId)->exists()) {
            return false; // User is already a member
        }
        $project->members()->attach($userId, ['project_role' => $role, 'id' => uuid_create()]);
        return true;
    }

    public function updateProjectMember($projectId, $userId, $role)
    {
        $project = $this->getProjectById($projectId);
        if (!$project->members()->where('user_id', $userId)->exists()) {
            return false; // User is not a member
        }
        $project->members()->updateExistingPivot($userId, ['project_role' => $role]);
        return true;
    }

    public function removeProjectMember($projectId, $userId)
    {
        $project = $this->getProjectById($projectId);
        if (!$project->members()->where('user_id', $userId)->exists()) {
            return false; // User is not a member
        }
        if ($project->created_by == $userId) {
            return false; // Owner cannot be removed
        }
        $project->members()->detach($userId);
        return true;
    }

    /**********************************
     **** Task related methods ********
     **********************************/

    public function getTaskById($id)
    {
        return $this->taskModel->with('assignee:id,email,first_name,last_name,picture', 'project')->findOrFail($id);
    }

    public function createTask($data)
    {
        $data['number'] = Task::generateTaskNumber([$data['project_id']]);
        $task = $this->taskModel->create($data);
        incrementProjectTaskNumber($task->project->project_key);
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
