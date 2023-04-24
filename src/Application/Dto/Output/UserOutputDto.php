<?php

namespace App\Application\Dto\Output;

class UserOutputDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $name
    ) {
    }
}
