<?php

namespace GenericCollection\Exceptions;

class UndefinedOffsetException extends GenericCollectionException
{
    public function __construct($message = "Undefined offset accessed.", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}