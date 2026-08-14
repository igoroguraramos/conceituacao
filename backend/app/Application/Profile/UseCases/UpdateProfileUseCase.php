<?php

namespace App\Application\Profile\UseCases;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Domain\Profile\Exceptions\SlugAlreadyInUseException;
use App\Models\Profile;

class UpdateProfileUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profiles
    ) {}

    public function execute(Profile $profile, array $data): Profile
    {
        if (
            isset($data['slug']) &&
            $this->profiles->slugExists(
                $data['slug'],
                $profile->id
            )
        ) {
            throw new SlugAlreadyInUseException();
        }

        return $this->profiles->update($profile, $data);
    }
}