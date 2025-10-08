<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    private $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the projects.
     *
     * @return array list of projects for the authenticated user
     */
    public function getProjects()
    {
        $projects = $this->projectService->getProjectsForUser();
        if ($projects->isEmpty()) {
            return apiResponse([], __('responses.item_not_found'));
        }
        return apiResponse($projects, __('responses.data_retrieved_successfully'));
    }

    /**
     * Display the specified project.
     *
     * @param  string  $id
     * @return array details of the specified project
     */
    public function getProject($id)
    {
        $project = $this->projectService->getProjectById($id);
        if (!$project) {
            return apiResponse([], __('responses.item_not_found'));
        }
        return apiResponse($project, __('responses.data_retrieved_successfully'));
    }

    /**
     * Store a new project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array details of the created project
     */
    public function createProject(ProjectRequest $request)
    {
        $data = $request->all();
        $project = $this->projectService->createProject($data);
        return apiResponse($project, __('responses.item_created_successfully'));
    }

    /**
     * Update the specified project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return array details of the updated project
     */
    public function updateProject(Request $request, $id)
    {
        $data = $request->all();
        $project = $this->projectService->updateProject($id, $data);
        return apiResponse($project, __('responses.item_updated_successfully'));
    }
    /**
     * Remove the specified project.
     *
     * @param  string  $id
     * @return array confirmation of project deletion
     */
    public function deleteProject($id)
    {
        $this->projectService->deleteProject($id);
        return apiResponse([], __('responses.item_deleted_successfully'));
    }

    /**
     * Add project member.
     * @param string $projectId
     */
    public function addProjectMember(Request $request, $projectId)
    {
        $userId = $request->input('user_id');
        $role = $request->input('role', 'member'); // Roles can be 'owner', 'admin', 'member', etc.
        if (!$userId) {
            return apiResponse([], __('responses.user_id_required'), 400);
        }
        $this->projectService->addProjectMember($projectId, $userId, $role);
        return apiResponse([], __('responses.member_added_successfully'));
    }

    /**
     * Update project member role.
     * @param string $projectId
     */
    public function updateProjectMember(Request $request, $projectId)
    {
        $userId = $request->input('user_id');
        $role = $request->input('role'); // New role
        if (!$this->projectService->updateProjectMember($projectId, $userId, $role)) {
            return apiResponse([], __('responses.cannot_update_member_role'), 400);
        }
        return apiResponse([], __('responses.member_role_updated_successfully'));
    }

    /**
     * Remove project member.
     * @param string $projectId
     * @param string $userId
     */
    public function removeProjectMember($projectId, $userId)
    {
        if (!$this->projectService->removeProjectMember($projectId, $userId)) {
            return apiResponse([], __('responses.cannot_remove_member'), 400);
        }
        return apiResponse([], __('responses.member_removed_successfully'));
    }

    // Task related methods can be added here or in a separate TaskController

    /**
     * Display the specified task.
     * @param  string  $taskId
     * @return array details of the specified task
     */
    public function getProjectTask($taskId)
    {
        $task = $this->projectService->getTaskById($taskId);
        if (!$task) {
            return apiResponse([], __('responses.item_not_found'));
        }
        return apiResponse($task, __('responses.data_retrieved_successfully'));
    }

    /**
     * Store a new task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array details of the created task
     */
    public function createProjectTask(Request $request)
    {
        $data = $request->all();
        $task = $this->projectService->createTask($data);
        return apiResponse($task, __('responses.item_created_successfully'));
    }

    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $taskId
     * @return array details of the updated task
     */
    public function updateProjectTask(Request $request, $taskId)
    {
        $data = $request->all();
        $task = $this->projectService->updateTask($taskId, $data);
        return apiResponse($task, __('responses.item_updated_successfully'));
    }

    /**
     * Remove the specified task.
     *
     * @param  string  $taskId
     * @return array confirmation of task deletion
     */
    public function deleteProjectTask($taskId)
    {
        $this->projectService->deleteTask($taskId);
        return apiResponse([], __('responses.item_deleted_successfully'));
    }
}
