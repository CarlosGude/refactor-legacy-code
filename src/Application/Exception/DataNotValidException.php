<?php

namespace App\Application\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class DataNotValidException extends \Exception
{
    protected ?ConstraintViolationListInterface $errors;

    public function getErrors(): ?ConstraintViolationListInterface
    {
        return $this->errors;
    }

    public function setErrors(?ConstraintViolationListInterface $errors): DataNotValidException
    {
        $this->errors = $errors;

        return $this;
    }
}
