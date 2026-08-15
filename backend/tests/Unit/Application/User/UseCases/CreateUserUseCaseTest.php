<?php

namespace Tests\Unit\Application\User\UseCases;

use App\Application\User\UseCases\CreateUserUseCase;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Domain\User\Exceptions\EmailAlreadyInUseException;
use App\Models\User;
use Tests\TestCase;

class CreateUserUseCaseTest extends TestCase
{
    public function test_should_throw_exception_when_email_already_exists(): void
    {
        $data = [
            'name' => 'Igor',
            'email' => 'igor@x.com',
            'password' => '12345678',
        ];

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository->method('emailExists')
            ->with($data['email'])
            ->willReturn(true);

        $useCase = new CreateUserUseCase($repository);

        $this->expectException(EmailAlreadyInUseException::class);

        $useCase->execute($data);
    }

    public function test_should_create_user_when_email_does_not_exist(): void
    {
        $data = [
            'name' => 'Igor',
            'email' => 'igor@x.com',
            'password' => '12345678',
        ];

        $user = new User($data);

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository->method('emailExists')
            ->with($data['email'])
            ->willReturn(false);

        $repository->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($user);

        $useCase = new CreateUserUseCase($repository);

        $result = $useCase->execute($data);

        $this->assertSame($user, $result);
    }
}