<?php

declare(strict_types=1);

namespace App\Application\Exception;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidRequestException extends InvalidArgumentException
{
    private array $errors = [];

    public static function createFromViolationList(
        ?ConstraintViolationListInterface $constraintViolationList = null
    ): self {
        $self = new self();

        if (!$constraintViolationList instanceof ConstraintViolationListInterface) {
            return $self;
        }

        foreach ($constraintViolationList as $constraint) {
            $self->addError($constraint->getPropertyPath(), $constraint->getMessage());
        }

        return $self;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addError(string $path, string $message): void
    {
        $this->errors[] = [
            'path' => $path,
            'message' => $message,
        ];
    }
}
