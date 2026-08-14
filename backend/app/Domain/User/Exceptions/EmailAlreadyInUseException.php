<?php

namespace App\Domain\User\Exceptions;

use RuntimeException;

class EmailAlreadyInUseException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('O email informado já está em uso por outro usuário.');
    }
}