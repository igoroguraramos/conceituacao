<?php

namespace Tests\Unit\Application\User\UseCases;

use App\Application\User\UseCases\UpdateUserUseCase;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Exceptions\EmailAlreadyInUseException;
use App\Models\User;
use Tests\TestCase;

class UpdateUserUseCaseTest extends TestCase
{
    public function test_should_throw_exception_when_new_email_is_already_in_use(): void
    {
        $user = new User([
            'name' => 'Igor',
            'email' => 'igor@x.com',
        ]);
        $user->id = 1;

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository->method('emailExists')
            ->with('outro@x.com', 1)
            ->willReturn(true);

        $useCase = new UpdateUserUseCase($repository);

        $this->expectException(EmailAlreadyInUseException::class);

        $useCase->execute($user, ['email' => 'outro@x.com']);
    }

    public function test_should_not_check_email_when_email_is_not_provided(): void
    {
        $user = new User([
            'name' => 'Igor',
            'email' => 'igor@x.com',
        ]);
        $user->id = 1;

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository->expects($this->never())
            ->method('emailExists');

        $repository->expects($this->once())
            ->method('update')
            ->with($user, ['name' => 'Igor Ramos'])
            ->willReturn($user);

        $useCase = new UpdateUserUseCase($repository);

        $useCase->execute($user, ['name' => 'Igor Ramos']);
    }
}