<?php

namespace App\Domain\Profile\Exceptions;

use RuntimeException;

class SlugAlreadyInUseException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('O slug informado já está em uso por outro perfil.');
    }
}