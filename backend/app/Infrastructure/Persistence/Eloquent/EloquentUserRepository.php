<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::with('profiles')->get();
    }

    public function find(int $id): User
    {
        return User::with('profiles')->findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user->fresh('profiles');
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function emailExists(
        string $email,
        ?int $exceptUserId = null
    ): bool {
        return User::query()
            ->where('email', $email)
            ->when(
                $exceptUserId,
                fn ($query) => $query->where('id', '!=', $exceptUserId)
            )
            ->exists();
    }
}