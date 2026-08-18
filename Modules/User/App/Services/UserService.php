<?php

namespace Modules\User\App\Services;

use Illuminate\Support\Facades\Hash;
use Modules\User\App\Interfaces\UserRepositoryInterface;

class UserService {
    public function __construct(private UserRepositoryInterface $userRepository) {}
    public function getAllUsers() {

        return $this->userRepository->all();
    }
    public function getUserById(int $id) {

        return $this->userRepository->find($id);
    }
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (!isset($data['status'])) {
            $data['status'] = true;
        }

        return $this->userRepository->create($data);
    }

    public function updateUser(int $id, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }
    public function deleteUser(int $id) {

        return $this->userRepository->delete($id);
    }
    public function searchUsers(?string $keyword, ?string $role, ?bool $status)
    {
        return $this->userRepository->search($keyword, $role, $status);
    }
}