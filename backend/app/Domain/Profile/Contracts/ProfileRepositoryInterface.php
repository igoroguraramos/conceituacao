<?php

namespace App\Domain\Profile\Contracts;

use App\Models\Profile;
use Illuminate\Support\Collection;

interface ProfileRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Profile;

    public function create(array $data): Profile;

    public function update(Profile $profile, array $data): Profile;

    public function delete(Profile $profile): void;

    public function slugExists(string $slug, ?int $exceptProfileId = null): bool;
}