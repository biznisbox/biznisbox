<?php

namespace App\Services;

use App\Enum\NotificationType;
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
        $projects = $this->projectModel
            ->with('partner', 'creator:id,email,first_name,last_name,picture', 'members')
            ->where('created_by', $userId)
            ->orWhereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
        createActivityLog('retrieveByUser', null, Project::$modelName, 'Project');
        return $projects;
    }

    public function getProjectById($id)
    {
        $userId = auth()->id();
        $projects = $this->projectModel
            ->with('tasks', 'partner', 'creator', 'members:id,email,first_name,last_name,picture')
            ->where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('created_by', $userId)->orWhereHas('members', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->firstOrFail();
        createActivityLog('retrieveById', $id, Project::$modelName, 'Project');
        return $projects;
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
        sendWebhookForEvent('project:created', $project->toArray());
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
        sendWebhookForEvent('project:updated', $project->toArray());
        return $project;
    }

    public function deleteProject($id)
    {
        $project = $this->getProjectById($id);
        sendWebhookForEvent('project:deleted', $project->toArray());
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
        sendWebhookForEvent('project:member_added', ['project_id' => $projectId, 'user_id' => $userId, 'role' => $role]);
        createNotification($userId, 'AddedToProject', 'AddedToProject', NotificationType::INFO, 'view', 'projects/' . $projectId);
        return true;
    }

    public function updateProjectMember($projectId, $userId, $role)
    {
        $project = $this->getProjectById($projectId);
        if (!$project->members()->where('user_id', $userId)->exists()) {
            return false; // User is not a member
        }
        $project->members()->updateExistingPivot($userId, ['project_role' => $role]);
        sendWebhookForEvent('project:member_updated', ['project_id' => $projectId, 'user_id' => $userId, 'role' => $role]);
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
        sendWebhookForEvent('project:member_removed', ['project_id' => $projectId, 'user_id' => $userId]);
        createNotification($userId, 'RemovedFromProject', 'RemovedFromProject', NotificationType::ERROR, 'view', 'projects');
        return true;
    }

    /**********************************
     **** Task related methods ********
     **********************************/

    public function getTaskById($id)
    {
        $task = $this->taskModel->with('assignee:id,email,first_name,last_name,picture', 'project')->findOrFail($id);
        createActivityLog('retrieveById', $id, Task::$modelName, 'Task');
        return $task;
    }

    public function createTask($data)
    {
        $data['number'] = Task::generateTaskNumber([$data['project_id']]);
        $task = $this->taskModel->create($data);
        incrementProjectTaskNumber($task->project->project_key);
        sendWebhookForEvent('task:created', $task->toArray());
        createNotification(
            $data['assigned_to'],
            'NewTaskAssigned',
            'NewTaskAssigned',
            NotificationType::INFO,
            'view',
            'projects/' . $data['project_id'] . '?task=' . $task->id,
        );
        return $task;
    }

    public function updateTask($id, $data)
    {
        $task = $this->taskModel->findOrFail($id);
        $task->update($data);
        sendWebhookForEvent('task:updated', $task->toArray());
        createNotification(
            $data['assigned_to'],
            'TaskUpdated',
            'TaskUpdated',
            NotificationType::WARNING,
            'view',
            'projects/' . $data['project_id'] . '?task=' . $task->id,
        );
        return $task;
    }

    public function deleteTask($id)
    {
        $task = $this->taskModel->findOrFail($id);
        sendWebhookForEvent('task:deleted', $task->toArray());
        return $task->delete();
    }
}
