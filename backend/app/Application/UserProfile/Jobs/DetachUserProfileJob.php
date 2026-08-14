<?php

namespace App\Application\UserProfile\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DetachUserProfileJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        public readonly int $userId,
        public readonly int $profileId,
    ) {}

    public function handle(): void
    {
        User::find($this->userId)?->profiles()->detach($this->profileId);
    }
}
