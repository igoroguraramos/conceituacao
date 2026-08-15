<?php

namespace Tests\Unit\Application\Profile\UseCases;

use App\Application\Profile\UseCases\CreateProfileUseCase;
use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Domain\Profile\Exceptions\SlugAlreadyInUseException;
use Tests\TestCase;

class CreateProfileUseCaseTest extends TestCase
{
    public function test_should_throw_exception_when_slug_already_exists(): void
    {
        $repository = $this->createMock(ProfileRepositoryInterface::class);

        $repository->method('slugExists')
            ->with('gerente')
            ->willReturn(true);

        $useCase = new CreateProfileUseCase($repository);

        $this->expectException(SlugAlreadyInUseException::class);

        $useCase->execute([
            'name' => 'Gerente',
            'slug' => 'gerente',
        ]);
    }
}