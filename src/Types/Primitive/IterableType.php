<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class IterableType
 *
 * Implements the TypeInterface to validate iterable values.
 *
 * @package GenericCollection\Types\Primitive
 */
class IterableType implements TypeInterface
{
    /**
     * Validate if a value is iterable.
     *
     * An iterable value is any value that can be iterated over, such as arrays and objects implementing `Traversable`.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is iterable, false otherwise.
     */
    public function validate($value): bool
    {
        return is_iterable($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "iterable";
    }
}
