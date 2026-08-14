<?php

namespace App\Application\Profile\UseCases;

use App\Domain\Profile\Contracts\ProfileRepositoryInterface;
use Illuminate\Support\Collection;

class ListProfilesUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profiles
    ) {
    }

    public function execute(): Collection
    {
        return $this->profiles->all();
    }
}