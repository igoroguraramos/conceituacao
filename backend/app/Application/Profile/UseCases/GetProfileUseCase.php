<?php

namespace App\Application\Profile\UseCases;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Models\Profile;

class GetProfileUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profiles
    ) {
    }

    public function execute(int $id): Profile
    {
        return $this->profiles->find($id);
    }
}