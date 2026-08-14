<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;

class GetUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function execute(int $id): User
    {
        return $this->users->find($id);
    }
}