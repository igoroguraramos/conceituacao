<?php

namespace Tests\Unit\Application\UserProfile\UseCases;

use App\Application\UserProfile\Jobs\DetachUserProfileJob;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetachUserProfileJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_detach_profile_from_user(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create();

        $user->profiles()->attach($profile);

        (new DetachUserProfileJob($user->id, $profile->id))->handle();

        $this->assertFalse(
            $user->profiles()
                ->where('profiles.id', $profile->id)
                ->exists()
        );
    }
}