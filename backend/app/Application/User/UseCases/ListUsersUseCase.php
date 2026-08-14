<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class ListUsersUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function execute(): Collection
    {
        return $this->users->all();
    }
}