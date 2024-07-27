<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class FloatType
 *
 * Implements the TypeInterface to validate float values.
 *
 * @package GenericCollection\Types\Primitive
 */
class FloatType implements TypeInterface
{
    /**
     * Validate if a value is a float.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is a float, false otherwise.
     */
    public function validate($value): bool
    {
        return is_float($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "float";
    }
}
