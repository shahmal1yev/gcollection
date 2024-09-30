<?php

namespace GenericCollection;

use ArrayIterator;
use Closure;
use Exception;
use GenericCollection\Exceptions\InvalidArgumentException;
use GenericCollection\Exceptions\UndefinedOffsetException;
use GenericCollection\Interfaces\GenericCollectionInterface;
use GenericCollection\Interfaces\TypeInterface;

/**
 * Class GenericCollection
 *
 * A generic collection class that supports type validation, CRUD operations, and array conversion.
 *
 * @package GenericCollection
 */
class GenericCollection implements GenericCollectionInterface
{
    /**
     * The type or closure used for validation of items in the collection.
     *
     * @var TypeInterface|Closure|string
     */
    protected $type;

    /**
     * The internal collection array.
     *
     * @var array
     */
    protected array $collection;

    /**
     * GenericCollection constructor.
     *
     * @param TypeInterface|Closure|string $type Type or closure used for validating collection items.
     * @param iterable $collection Initial collection of items.
     * @throws InvalidArgumentException If the type is invalid or does not exist.
     */
    public function __construct($type, iterable $collection = [])
    {
        $this->type = $this->typecast($type);
        $this->collection = $this->fill($collection);
    }

    /**
     * Cast the type to an acceptable form for validation.
     *
     * @param TypeInterface|Closure|string $type The type or closure to cast.
     * @return TypeInterface|Closure|string The casted type.
     * @throws InvalidArgumentException If the type is not acceptable.
     */
    protected function typecast($type)
    {
        if ($type instanceof TypeInterface) {
            return $type;
        }

        if ($type instanceof Closure) {
            return fn ($value): bool => $type($value);
        }

        if (is_string($type)) {
            if (class_exists($type)) {
                return $type;
            }

            throw new InvalidArgumentException("$type does not exist.");
        }

        $acceptableTypes = implode(", ", [
            TypeInterface::class,
            sprintf("%s(\$value): bool", Closure::class),
            "string"
        ]);

        throw new InvalidArgumentException(sprintf(
            "'\$type' must be an instance of one of the following types: %s.",
            $acceptableTypes
        ));
    }

    /**
     * Fill the collection with validated items.
     *
     * @param iterable $collection The initial collection of items.
     * @return array The filled collection array.
     * @throws InvalidArgumentException If an item in the collection is invalid.
     */
    protected function fill(iterable $collection): array
    {
        foreach ($collection as $item) {
            $this->validateWithException($item);
        }

        return is_array($collection) ? $collection : iterator_to_array($collection);
    }

    /**
     * Validate a value according to the type or closure.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is valid, false otherwise.
     */
    public function validate($value): bool
    {
        if ($this->type instanceof TypeInterface) {
            return $this->type->validate($value);
        }

        if ($this->type instanceof Closure) {
            return call_user_func($this->type, $value);
        }

        return $value instanceof $this->type;
    }

    /**
     * Validate a value and throw an exception if it's not valid.
     *
     * @param mixed $value The value to validate.
     * @throws InvalidArgumentException If the value is not valid.
     */
    public function validateWithException($value): void
    {
        if (!$this->validate($value)) {
            throw new InvalidArgumentException(sprintf("'\$value' is not of type %s.", $this->gettype()));
        }
    }

    /**
     * Check if an offset exists in the collection.
     *
     * @param mixed $offset The offset to check.
     * @return bool True if the offset exists, false otherwise.
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->collection);
    }

    /**
     * Get the value at the specified offset.
     *
     * @param mixed $offset The offset to retrieve.
     * @return mixed The value at the offset.
     * @throws UndefinedOffsetException If the offset does not exist.
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new UndefinedOffsetException("Offset $offset does not exist.");
        }

        return $this->collection[$offset];
    }

    /**
     * Set a value at the specified offset.
     *
     * @param int|string $offset The offset to set.
     * @param mixed $value The value to set.
     * @throws InvalidArgumentException If the value is not valid.
     */
    public function offsetSet($offset, $value): void
    {
        $this->validateWithException($value);

        if (is_null($offset)) {
            $this->collection[] = $value;
            return;
        }

        $this->collection[$offset] = $value;
    }

    /**
     * Unset a value at the specified offset.
     *
     * @param mixed $offset The offset to unset.
     */
    public function offsetUnset($offset): void
    {
        unset($this->collection[$offset]);
    }

    /**
     * Get an iterator for the collection.
     *
     * @return ArrayIterator The iterator for the collection.
     * @throws InvalidArgumentException If there is an error creating the iterator.
     */
    public function getIterator(): ArrayIterator
    {
        try {
            return new ArrayIterator($this->collection);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Add a value to the collection at the specified offset.
     *
     * @param mixed $offset The offset to add.
     * @param mixed $value The value to add.
     * @return GenericCollectionInterface The updated collection.
     * @throws InvalidArgumentException If the value is not valid.
     */
    public function add($offset, $value): GenericCollectionInterface
    {
        $this->offsetSet($offset, $value);
        return $this;
    }

    /**
     * Get the value at the specified offset.
     *
     * @param mixed $offset The offset to retrieve.
     * @return mixed The value at the offset.
     */
    public function get($offset)
    {
        return $this->collection[$offset];
    }

    /**
     * Remove the value at the specified offset.
     *
     * @param mixed $offset The offset to remove.
     * @return GenericCollectionInterface The updated collection.
     */
    public function remove($offset): GenericCollectionInterface
    {
        $this->offsetUnset($offset);
        return $this;
    }

    /**
     * Get all items in the collection as an ArrayIterator.
     *
     * @return ArrayIterator The collection as an ArrayIterator.
     * @throws Exception If there is an error creating the iterator.
     */
    public function all(): ArrayIterator
    {
        return $this->getIterator();
    }

    /**
     * Convert the collection to an array.
     *
     * @return array The collection as an array.
     */
    public function toArray(): array
    {
        return $this->collection;
    }

    /**
     * Get the type or class name used for validation.
     *
     * @return string The type or class name.
     */
    public function gettype(): string
    {
        if ($this->type instanceof TypeInterface || $this->type instanceof Closure) {
            return get_class($this->type);
        }

        return $this->type;
    }

    /**
     * Get the number of items in the collection.
     *
     * @return int The number of items in the collection.
     */
    public function count(): int
    {
        return count($this->collection);
    }
}
