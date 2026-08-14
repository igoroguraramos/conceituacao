<?php

namespace App\Domain\UserProfile\Contracts;

use App\Models\User;

interface UserProfileRepositoryInterface
{
    public function sync(
        User $user,
        array $profileIds
    ): void;

    public function detach(
        User $user,
        int $profileId
    ): void;
}