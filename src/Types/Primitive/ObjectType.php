<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class ObjectType
 *
 * Implements the TypeInterface to validate object values.
 *
 * @package GenericCollection\Types\Primitive
 */
class ObjectType implements TypeInterface
{
    /**
     * Validate if a value is an object.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is an object, false otherwise.
     */
    public function validate($value): bool
    {
        return is_object($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "object";
    }
}
