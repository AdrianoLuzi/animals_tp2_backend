<?php

namespace App\Exceptions;

use Exception;

class AnimalNotFoundException extends Exception
{
    public static function forId(string $id)
    {
        return new self("El animal con ID \"$id\" no fue encontrado.");
    }
}