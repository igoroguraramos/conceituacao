<?php

namespace App\Application\Profile\UseCases;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Domain\Profile\Exceptions\SlugAlreadyInUseException;
use App\Models\Profile;

class CreateProfileUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profiles
    ) {
    }

    public function execute(array $data): Profile
    {
        if ($this->profiles->slugExists($data['slug'])) {
            throw new SlugAlreadyInUseException();
        }

        return $this->profiles->create($data);
    }
}