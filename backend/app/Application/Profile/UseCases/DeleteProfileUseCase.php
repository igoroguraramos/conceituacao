<?php

namespace App\Application\Profile\UseCases;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Models\Profile;

class DeleteProfileUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profiles
    ) {
    }

    public function execute(Profile $profile): void
    {
        $this->profiles->delete($profile);
    }
}