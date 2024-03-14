<?php

namespace Acheron\Exceptions;

class InvalidClientException extends \Exception
{
    public const CODE = 100;

    public function __construct($message, $code = self::CODE, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
