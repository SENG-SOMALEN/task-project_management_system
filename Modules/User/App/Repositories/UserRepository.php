<?php

namespace Modules\User\App\Repositories;

use Modules\User\App\Models\User;
use Modules\User\App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    public function __construct(private User $user){}
    public function all()
    {
        return $this->user->paginate(5);
    }
    public function find(int $id)
    {
        return $this->user->find($id);
    }
    public function create(array $data)
    {
        return $this->user->create($data);
    }
    public function update(int $id, array $data)
    {
        $user = $this->user->findOrFail($id);

        $user->update($data);

        return $user;
    }
    public function delete(int $id)
    {
        $user = $this->user->findOrFail($id);

        return $user->delete();
    }
    public function search(?string $keyword, ?string $role, ?bool $status)
    {
        return $this->user
                        ->when($keyword, function($query) use ($keyword) {
                            $query->where('username', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%");
                        })
                        ->when($role, function($query) use ($role) {
                            $query->where('role', $role);
                        })
                        ->when(!is_null($status), function($query) use ($status){
                            $query->where('status', $status);
                        })->get();
    }

    public function findByEmail(string $email)
    {
        return $this->user
            ->where('email', $email)
            ->first();
    }
}