<?php

namespace App\Application\Exception;

final class DataNotValidException extends \Exception
{
    /** @var array<string, string> */
    protected array $errors;

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array<string, string> $errors
     *
     * @return $this
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }
}
