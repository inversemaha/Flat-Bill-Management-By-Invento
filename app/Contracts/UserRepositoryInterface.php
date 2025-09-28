<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all house owners
     */
    public function getHouseOwners(): Collection;

    /**
     * Get paginated house owners
     */
    public function getPaginatedHouseOwners(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get pending house owners (awaiting approval)
     */
    public function getPendingHouseOwners(): Collection;

    /**
     * Get active house owners
     */
    public function getActiveHouseOwners(): Collection;

    /**
     * Get all admins
     */
    public function getAdmins(): Collection;

    /**
     * Approve/activate a pending user
     */
    public function approveUser(User $user): bool;

    /**
     * Deactivate a user
     */
    public function deactivateUser(User $user): bool;

    /**
     * Create a house owner
     */
    public function createHouseOwner(array $data): User;

    /**
     * Create an admin
     */
    public function createAdmin(array $data): User;

    /**
     * Update user status
     */
    public function updateStatus(User $user, string $status): bool;

    /**
     * Get users by role
     */
    public function getUsersByRole(string $role): Collection;

    /**
     * Get users by status
     */
    public function getUsersByStatus(string $status): Collection;

    /**
     * Get recent users by creation date
     */
    public function getRecentUsers(int $limit = 10): Collection;
}