<?php

namespace Tests\Unit\Application\Profile\UseCases;

use App\Application\Profile\UseCases\UpdateProfileUseCase;
use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use App\Domain\Profile\Exceptions\SlugAlreadyInUseException;
use App\Models\Profile;
use Tests\TestCase;

class UpdateProfileUseCaseTest extends TestCase
{
    public function test_should_throw_exception_when_new_slug_is_already_in_use_by_another_profile(): void
    {
        $profile = new Profile([
            'name' => 'Gerente',
            'slug' => 'gerente',
        ]);
        $profile->id = 1;

        $repository = $this->createMock(ProfileRepositoryInterface::class);

        $repository->method('slugExists')
            ->with('admin', 1)
            ->willReturn(true);

        $useCase = new UpdateProfileUseCase($repository);

        $this->expectException(SlugAlreadyInUseException::class);

        $useCase->execute($profile, ['slug' => 'admin']);
    }
}