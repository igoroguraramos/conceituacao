<?php
namespace App\Application\UserProfile\UseCases;

use App\Models\User;
use App\Domain\UserProfile\Contracts\UserProfileRepositoryInterface;
class SyncUserProfilesUseCase
{
    public function __construct(
        private readonly UserProfileRepositoryInterface $userProfiles
    ) {
    }

    public function execute(User $userId, array $profileIds): void
    {
        $this->userProfiles->sync($userId, $profileIds);
    }
}