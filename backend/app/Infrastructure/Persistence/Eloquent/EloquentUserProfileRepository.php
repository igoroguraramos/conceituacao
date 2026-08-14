<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\UserProfile\Contracts\UserProfileRepositoryInterface;
use App\Models\User;

class EloquentUserProfileRepository implements UserProfileRepositoryInterface
{
    public function sync(
        User $user,
        array $profileIds
    ): void {
        $user->profiles()->sync($profileIds);
    }

    public function detach(
        User $user,
        int $profileId
    ): void {
        $user->profiles()->detach($profileId);
    }
}