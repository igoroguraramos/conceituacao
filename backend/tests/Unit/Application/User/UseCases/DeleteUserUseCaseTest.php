<?php

namespace Tests\Unit\Application\User\UseCases;

use App\Application\User\UseCases\DeleteUserUseCase;
use App\Domain\User\Contracts\UserRepositoryInterface;
use App\Models\User;
use Tests\TestCase;

class DeleteUserUseCaseTest extends TestCase
{
    public function test_should_delete_user(): void
    {
        $user = new User([
            'name' => 'Igor',
            'email' => 'igor@x.com',
        ]);

        $repository = $this->createMock(UserRepositoryInterface::class);

        $repository->expects($this->once())
            ->method('delete')
            ->with($user);

        $useCase = new DeleteUserUseCase($repository);

        $useCase->execute($user);
    }
}