<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class UserService extends BaseService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get paginated house owners for admin
     */
    public function getPaginatedHouseOwners(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getPaginatedHouseOwners($perPage);
    }

    /**
     * Get pending house owners awaiting approval
     */
    public function getPendingHouseOwners(): Collection
    {
        return $this->userRepository->getPendingHouseOwners();
    }

    /**
     * Get all admins
     */
    public function getAdmins(): Collection
    {
        return $this->userRepository->getAdmins();
    }

    /**
     * Create a new house owner (by admin)
     */
    public function createHouseOwner(array $data): User
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->createHouseOwner($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a new admin (by super admin)
     */
    public function createAdmin(array $data): User
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->createAdmin($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Approve a pending house owner
     */
    public function approveHouseOwner(User $user): bool
    {
        if (!$user->isHouseOwner() || !$user->isPending()) {
            throw new Exception('User is not a pending house owner');
        }

        return $this->userRepository->approveUser($user);
    }

    /**
     * Deactivate a user
     */
    public function deactivateUser(User $user): bool
    {
        if ($user->isAdmin()) {
            throw new Exception('Cannot deactivate admin users');
        }

        return $this->userRepository->deactivateUser($user);
    }

    /**
     * Reactivate a user
     */
    public function reactivateUser(User $user): bool
    {
        return $this->userRepository->updateStatus($user, 'active');
    }

    /**
     * Update user details
     */
    public function updateUser(User $user, array $data): User
    {
        try {
            DB::beginTransaction();

            // Remove password if not provided
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            $updatedUser = $this->userRepository->update($user, $data);

            DB::commit();
            return $updatedUser;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getUserStats(): array
    {
        return [
            'total_house_owners' => $this->userRepository->getUsersByRole('house_owner')->count(),
            'active_house_owners' => $this->userRepository->getActiveHouseOwners()->count(),
            'pending_house_owners' => $this->userRepository->getPendingHouseOwners()->count(),
            'total_admins' => $this->userRepository->getAdmins()->count(),
        ];
    }

    /**
     * Get total count of house owners
     */
    public function getTotalHouseOwners(): int
    {
        return $this->userRepository->getUsersByRole('house_owner')->count();
    }

    /**
     * Get count of active house owners
     */
    public function getActiveHouseOwners(): int
    {
        return $this->userRepository->getActiveHouseOwners()->count();
    }

    /**
     * Get pending users for approval
     */
    public function getPendingUsers(): Collection
    {
        return $this->userRepository->getPendingHouseOwners();
    }

    /**
     * Get recent user registrations
     */
    public function getRecentRegistrations(int $limit = 10): Collection
    {
        return $this->userRepository->getRecentUsers($limit);
    }
}