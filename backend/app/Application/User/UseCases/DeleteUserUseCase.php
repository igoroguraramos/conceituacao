<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;

class DeleteUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function execute(User $user): void
    {
        $this->users->delete($user);
    }
}