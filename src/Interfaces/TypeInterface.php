<?php

namespace GenericCollection\Interfaces;

/**
 * Interface TypeInterface
 *
 * This interface defines a method for validating values based on type-specific rules.
 *
 * @package GenericCollection\Interfaces
 */
interface TypeInterface
{
    /**
     * Validate if a value meets the type-specific criteria.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is valid according to type-specific rules, false otherwise.
     */
    public function validate($value): bool;
}
