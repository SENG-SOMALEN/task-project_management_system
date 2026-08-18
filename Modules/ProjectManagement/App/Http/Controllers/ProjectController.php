<?php

namespace Modules\ProjectManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ProjectManagement\App\Services\ProjectService;
use Modules\ProjectManagement\App\Http\Resources\ProjectResource;
use Modules\ProjectManagement\App\Http\Requests\StoreProjectRequest;
use Modules\ProjectManagement\App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $project = $this->projectService->searchFilterProject(
            $request->query('search'),
            $request->query('status')
        );

        return ProjectResource::collection($project);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->validated());

        return new ProjectResource($project);
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id)
    {
        $project = $this->projectService->getProjectById($id);

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        $project = $this->projectService->updateProject($id, $request->validated());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->projectService->deleteProject($id);

        return response()->json([
            'status' => true,
            'message' => 'Project deleted successfully.'
        ], 200);
    }
}
