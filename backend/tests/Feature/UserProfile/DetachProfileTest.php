<?php

namespace Tests\Feature\UserProfile;

use App\Application\UserProfile\Jobs\DetachUserProfileJob;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class DetachProfileTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create();
        $adminProfile = Profile::factory()->create(['slug' => 'admin']);

        $admin->profiles()->attach($adminProfile);

        $this->actingAs($admin, 'sanctum');

        return $admin;
    }

    public function test_should_dispatch_detach_job_and_return_202(): void
    {
        Bus::fake();

        $this->actingAsAdmin();

        $user = User::factory()->create();
        $profile = Profile::factory()->create();

        $user->profiles()->attach($profile);

        $this->deleteJson("/api/users/{$user->id}/profiles", [
            'profiles' => [$profile->id],
        ])
            ->assertStatus(202);

        Bus::assertDispatched(
            DetachUserProfileJob::class,
            fn (DetachUserProfileJob $job) =>
                $job->userId === $user->id &&
                $job->profileId === $profile->id
        );

        $this->assertDatabaseHas('user_profile', [
            'user_id' => $user->id,
            'profile_id' => $profile->id,
        ]);
    }

    public function test_should_return_403_when_user_is_not_admin(): void
    {
        $user = User::factory()->create();
        $target = User::factory()->create();
        $profile = Profile::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->deleteJson(
                "/api/users/{$target->id}/profiles",
                ['profiles' => [$profile->id]]
            )
            ->assertStatus(403);
    }
}