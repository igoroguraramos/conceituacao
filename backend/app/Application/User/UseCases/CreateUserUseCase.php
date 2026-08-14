<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Exceptions\EmailAlreadyInUseException;
use App\Models\User;

class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function execute(array $data): User
    {
        if ($this->users->emailExists($data['email'])) {
            throw new EmailAlreadyInUseException();
        }

        return $this->users->create($data);
    }
}