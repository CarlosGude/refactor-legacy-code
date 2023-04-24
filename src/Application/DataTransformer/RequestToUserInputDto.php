<?php

namespace App\Application\DataTransformer;

use App\Application\Dto\Input\UserInputDto;
use App\Application\Exception\RequestNotValidException;

final class RequestToUserInputDto
{
    private string $name;
    private string $email;

    /**
     * @param array<string, string> $body
     *
     * @throws RequestNotValidException
     */
    public function __construct(array $body)
    {
        if (array_keys($body) == ['email', 'name']) {
            throw new RequestNotValidException();
        }

        $this->name = $body['name'];
        $this->email = $body['email'];
    }

    public function transform(): UserInputDto
    {
        return new UserInputDto(
            email: $this->email,
            name: $this->name
        );
    }
}
