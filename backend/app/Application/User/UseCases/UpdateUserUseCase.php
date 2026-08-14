<?php

namespace App\Application\User\UseCases;

use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Exceptions\EmailAlreadyInUseException;
use App\Models\User;

class UpdateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function execute(User $user, array $data): User
    {
        if (
            isset($data['email']) &&
            $this->users->emailExists($data['email'], $user->id)
        ) {
            throw new EmailAlreadyInUseException();
        }

        return $this->users->update($user, $data);
    }
}