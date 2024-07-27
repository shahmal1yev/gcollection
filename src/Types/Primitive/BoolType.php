<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class BoolType
 *
 * Implements the TypeInterface to validate boolean values.
 *
 * @package GenericCollection\Types\Primitive
 */
class BoolType implements TypeInterface
{
    /**
     * Validate if a value is a boolean.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is a boolean, false otherwise.
     */
    public function validate($value): bool
    {
        return is_bool($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "bool";
    }
}
