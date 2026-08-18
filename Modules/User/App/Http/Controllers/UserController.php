<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\App\Services\UserService;
use Modules\User\App\Http\Requests\StoreUserRequest;
use Modules\User\App\Http\Requests\UpdateUserRequest;
use Modules\User\App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(Request $request) {

        $users = $this->userService->searchUsers(
            $request->query('search'),
            $request->query('role'),
            $request->has('status')
                ? filter_var($request->query('status'), FILTER_VALIDATE_BOOLEAN)
                : null
        );

        return UserResource::collection($users);
    }
    public function show(int $id) {

        $user = $this->userService->getUserById($id);

        return new UserResource($user);
    }
    public function store(StoreUserRequest $required) {

        $user = $this->userService->createUser($required->validated());

        return new UserResource($user);
    }
    public function update(UpdateUserRequest $required, int $id) {

        $user = $this->userService->updateUser($id, $required->validated());

        return new UserResource($user);
    }
    public function destroy(int $id) {

        $this->userService->deleteUser($id);

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully.'
        ], 200);
    }
}