<?php

namespace GenericCollection\Interfaces;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * Interface GenericCollectionInterface
 *
 * This interface defines a generic collection with basic CRUD operations, validation, and conversion methods.
 *
 * @package GenericCollection\Interfaces
 */
interface GenericCollectionInterface extends ArrayAccess, IteratorAggregate, Countable
{
    /**
     * Retrieve all items in the collection as an ArrayIterator.
     *
     * @return ArrayIterator
     */
    public function all(): ArrayIterator;

    /**
     * Add a value to the collection at the specified offset.
     *
     * @param mixed $offset The offset at which the value should be added.
     * @param mixed $value The value to be added.
     * @return GenericCollectionInterface
     */
    public function add($offset, $value): GenericCollectionInterface;

    /**
     * Get the value at the specified offset.
     *
     * @param mixed $offset The offset of the value to retrieve.
     * @return mixed The value at the specified offset.
     */
    public function get($offset);

    /**
     * Remove the value at the specified offset.
     *
     * @param mixed $offset The offset of the value to remove.
     * @return GenericCollectionInterface
     */
    public function remove($offset): GenericCollectionInterface;

    /**
     * Validate if a value is acceptable in the collection.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is valid, false otherwise.
     */
    public function validate($value): bool;

    /**
     * Validate if a value is acceptable in the collection and throw an exception if not.
     *
     * @param mixed $value The value to validate.
     * @throws \InvalidArgumentException If the value is not valid.
     */
    public function validateWithException($value): void;

    /**
     * Convert the collection to an array.
     *
     * @return array The collection as an array.
     */
    public function toArray(): array;

    /**
     * Get the type of the collection.
     *
     * @return string The type of the collection.
     */
    public function gettype(): string;
}
