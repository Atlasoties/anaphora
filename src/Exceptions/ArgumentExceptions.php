<?php

namespace Jaktech\Anaphora\Exceptions;

use Throwable;

class ArgumentExceptions extends \Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get a human-readable message for the exception.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return "Invalid argument: " . $this->getMessage();
    }

    /**
     * Get the error code for the exception.
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->getCode();
    }
}
