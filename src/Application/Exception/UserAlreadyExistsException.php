<?php

declare(strict_types=1);

namespace App\Application\Exception;

use InvalidArgumentException;

class UserAlreadyExistsException extends InvalidArgumentException
{
}
