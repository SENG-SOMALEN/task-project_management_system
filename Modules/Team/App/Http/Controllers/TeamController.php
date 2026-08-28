<?php

namespace Modules\Team\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Team\App\Http\Requests\StoreTeamRequest;
use Modules\Team\App\Http\Requests\UpdateTeamRequest;
use Modules\Team\App\Resources\TeamResource;
use Modules\Team\App\Services\TeamService;

class TeamController extends Controller
{
    public function __construct(
        private TeamService $teamService
    ) {}

    /**
     * Display a listing of teams.
     */
    public function index(): JsonResponse
    {
        $teams = $this->teamService->getAllTeams();

        return response()->json([
            'message' => 'Teams retrieved successfully.',
            'data' => TeamResource::collection($teams),
        ], 200);
    }

    /**
     * Store a newly created team.
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['created_by'] = auth()->user()->user_id;

        $team = $this->teamService->createTeam($data);

        return response()->json([
            'message' => 'Team created successfully.',
            'data' => new TeamResource($team),
        ], 201);
    }

    /**
     * Display the specified team.
     */
    public function show(int $id): JsonResponse
    {
        $team = $this->teamService->getTeamById($id);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Team retrieved successfully.',
            'data' => new TeamResource($team),
        ], 200);
    }

    /**
     * Update the specified team.
     */
    public function update(
        UpdateTeamRequest $request,
        int $id
    ): JsonResponse {
        $team = $this->teamService->getTeamById($id);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }

        $team = $this->teamService->updateTeam(
            $id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Team updated successfully.',
            'data' => new TeamResource($team),
        ], 200);
    }

    /**
     * Remove the specified team.
     */
    public function destroy(int $id): JsonResponse
    {
        $team = $this->teamService->getTeamById($id);

        if (!$team) {
            return response()->json([
                'message' => 'Team not found.',
            ], 404);
        }

        $this->teamService->deleteTeam($id);

        return response()->json([
            'message' => 'Team deleted successfully.',
        ], 200);
    }
}