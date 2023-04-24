<?php

namespace App\Application\Dto\Input;

class UserInputDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $name
    ) {
    }
}
