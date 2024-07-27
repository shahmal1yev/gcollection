<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class StringType
 *
 * Implements the TypeInterface to validate string values.
 *
 * @package GenericCollection\Types\Primitive
 */
class StringType implements TypeInterface
{
    /**
     * Validate if a value is a string.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is a string, false otherwise.
     */
    public function validate($value): bool
    {
        return is_string($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "string";
    }
}
