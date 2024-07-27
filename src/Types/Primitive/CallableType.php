<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class CallableType
 *
 * Implements the TypeInterface to validate callable values.
 *
 * @package GenericCollection\Types\Primitive
 */
class CallableType implements TypeInterface
{
    /**
     * Validate if a value is callable.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is callable, false otherwise.
     */
    public function validate($value): bool
    {
        return is_callable($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "callable";
    }
}
