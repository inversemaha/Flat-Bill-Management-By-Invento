<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all house owners
     */
    public function getHouseOwners(): Collection
    {
        return $this->model->where('role', 'house_owner')->get();
    }

    /**
     * Get paginated house owners
     */
    public function getPaginatedHouseOwners(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->where('role', 'house_owner')
            ->with('buildings')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get pending house owners (awaiting approval)
     */
    public function getPendingHouseOwners(): Collection
    {
        return $this->model->where('role', 'house_owner')
            ->where('status', 'pending')
            ->get();
    }

    /**
     * Get active house owners
     */
    public function getActiveHouseOwners(): Collection
    {
        return $this->model->where('role', 'house_owner')
            ->where('status', 'active')
            ->get();
    }

    /**
     * Get all admins
     */
    public function getAdmins(): Collection
    {
        return $this->model->where('role', 'admin')->get();
    }

    /**
     * Approve/activate a pending user
     */
    public function approveUser(User $user): bool
    {
        return $user->update(['status' => 'active']);
    }

    /**
     * Deactivate a user
     */
    public function deactivateUser(User $user): bool
    {
        return $user->update(['status' => 'inactive']);
    }

    /**
     * Create a house owner
     */
    public function createHouseOwner(array $data): User
    {
        $data['role'] = 'house_owner';
        $data['status'] = 'active'; // Admin created house owners are active by default
        $data['password'] = Hash::make($data['password']);
        
        return $this->model->create($data);
    }

    /**
     * Create an admin
     */
    public function createAdmin(array $data): User
    {
        $data['role'] = 'admin';
        $data['status'] = 'active'; // Admins are always active
        $data['password'] = Hash::make($data['password']);
        
        return $this->model->create($data);
    }

    /**
     * Update user status
     */
    public function updateStatus(User $user, string $status): bool
    {
        return $user->update(['status' => $status]);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $role): Collection
    {
        return $this->model->where('role', $role)->get();
    }

    /**
     * Get users by status
     */
    public function getUsersByStatus(string $status): Collection
    {
        return $this->model->where('status', $status)->get();
    }

    /**
     * Get recent users by creation date
     */
    public function getRecentUsers(int $limit = 10): Collection
    {
        return $this->model->latest('created_at')->limit($limit)->get();
    }
}