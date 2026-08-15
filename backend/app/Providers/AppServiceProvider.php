<?php

namespace App\Providers;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\UserProfile\Contracts\UserProfileRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentProfileRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentUserProfileRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
        $this->app->bind(
            ProfileRepositoryInterface::class,
            EloquentProfileRepository::class
        );
        $this->app->bind(
            UserProfileRepositoryInterface::class,
            EloquentUserProfileRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
