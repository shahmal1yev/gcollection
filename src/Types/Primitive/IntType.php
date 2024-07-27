<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class IntType
 *
 * Implements the TypeInterface to validate integer values.
 *
 * @package GenericCollection\Types\Primitive
 */
class IntType implements TypeInterface
{
    /**
     * Validate if a value is an integer.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is an integer, false otherwise.
     */
    public function validate($value): bool
    {
        return is_int($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "integer";
    }
}
