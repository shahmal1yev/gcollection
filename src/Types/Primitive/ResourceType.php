<?php

namespace GenericCollection\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;

/**
 * Class ResourceType
 *
 * Implements the TypeInterface to validate resource values.
 *
 * @package GenericCollection\Types\Primitive
 */
class ResourceType implements TypeInterface
{
    /**
     * Validate if a value is a resource.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is a resource, false otherwise.
     */
    public function validate($value): bool
    {
        return is_resource($value);
    }

    /**
     * Return the string representation of the type.
     *
     * @return string The type as a string.
     */
    public function __toString()
    {
        return "resource";
    }
}
