<?php

namespace App\Application\UseCase;

use App\Application\Dto\Input\UserInputDto;
use App\Application\Dto\Output\UserOutputDto;
use App\Application\Exception\DataNotValidException;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PostUserCase
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function post(UserInputDto $inputDto): UserOutputDto
    {
        $existUser = $this->userRepository->existUserWithEmail($inputDto->email);
        if ($existUser) {
            return new UserOutputDto(
                email: $existUser->getEmail(), name: $existUser->getName()
            );
        }

        $user = $this->userRepository->create(
            email: $inputDto->email,
            name: $inputDto->name
        );
        $errors = $this->validator->validate($user);

        if ($errors->count() > 0) {
            $exception = new DataNotValidException();
            $exception->setErrors($errors);
        }

        $this->userRepository->save($user, true);

        return new UserOutputDto(
            email: $user->getEmail(), name: $user->getName()
        );
    }
}
