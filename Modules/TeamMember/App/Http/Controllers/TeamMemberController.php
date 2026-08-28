<?php

namespace Modules\TeamMember\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\TeamMember\App\Http\Requests\StoreTeamMemberRequest;
use Modules\TeamMember\App\Http\Resources\TeamMemberResource;
use Modules\TeamMember\App\Services\TeamMemberService;

class TeamMemberController extends Controller
{
    public function __construct(
        private TeamMemberService $teamMemberService
    ) {}

    /**
     * Display a listing of all team members.
     */
    public function index(): JsonResponse
    {
        $teamMembers = $this->teamMemberService->getAllTeamMembers();

        return response()->json([
            'message' => 'Team members retrieved successfully.',
            'data' => TeamMemberResource::collection($teamMembers),
        ], 200);
    }

    /**
     * Display team members of a specific team.
     */
    public function members(int $teamId): JsonResponse
    {
        $teamMembers = $this->teamMemberService
            ->getTeamMembersByTeamId($teamId);

        return response()->json([
            'message' => 'Team members retrieved successfully.',
            'data' => TeamMemberResource::collection($teamMembers),
        ], 200);
    }

    /**
     * Add a user to a team.
     */
    public function store(
        StoreTeamMemberRequest $request,
        int $teamId
    ): JsonResponse {
        $teamMember = $this->teamMemberService->addMember(
            $teamId,
            $request->validated()['user_id']
        );

        return response()->json([
            'message' => 'Team member added successfully.',
            'data' => new TeamMemberResource($teamMember),
        ], 201);
    }

    /**
     * Display the specified team member.
     */
    public function show(int $id): JsonResponse
    {
        $teamMember = $this->teamMemberService
            ->getTeamMemberById($id);

        if (!$teamMember) {
            return response()->json([
                'message' => 'Team member not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Team member retrieved successfully.',
            'data' => new TeamMemberResource($teamMember),
        ], 200);
    }

    /**
     * Remove a user from a team.
     */
    public function destroy(int $id): JsonResponse
    {
        $teamMember = $this->teamMemberService
            ->getTeamMemberById($id);

        if (!$teamMember) {
            return response()->json([
                'message' => 'Team member not found.',
            ], 404);
        }

        $this->teamMemberService->removeMember($id);

        return response()->json([
            'message' => 'Team member removed successfully.',
        ], 200);
    }
}