<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Models\Profile;
use Illuminate\Support\Collection;

class EloquentProfileRepository implements ProfileRepositoryInterface
{
    public function all(): Collection
    {
        return Profile::with('users')->get();
    }

    public function find(int $id): Profile
    {
        return Profile::with('users')->findOrFail($id);
    }

    public function create(array $data): Profile
    {
        return Profile::create($data);
    }

    public function update(Profile $profile, array $data): Profile
    {
        $profile->update($data);

        return $profile->fresh('users');
    }

    public function delete(Profile $profile): void
    {
        $profile->delete();
    }

    public function slugExists(
        string $slug,
        ?int $exceptProfileId = null
    ): bool {
        return Profile::query()
            ->where('slug', $slug)
            ->when(
                $exceptProfileId,
                fn ($query) => $query->where('id', '!=', $exceptProfileId)
            )
            ->exists();
    }
}