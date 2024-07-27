<?php

namespace Tests\Feature;

use ArrayIterator;
use Countable;
use Exception;
use GenericCollection\Exceptions\UndefinedOffsetException;
use GenericCollection\Exceptions\InvalidArgumentException;
use GenericCollection\GenericCollection;
use GenericCollection\Interfaces\GenericCollectionInterface;
use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\IntType;
use GenericCollection\Types\Primitive\StringType;
use PHPUnit\Framework\TestCase;

class GenericCollectionTest extends TestCase
{
    /**
     * Test constructor with a class string.
     *
     * This test verifies that a class instance can be correctly added to
     * the collection when using the class name as the type.
     *
     * @throws InvalidArgumentException If an invalid argument is provided.
     */
    public function testConstructorWithNamespace(): void
    {
        $class = new class {};
        $type = get_class($class);

        $collection = new GenericCollection($type);
        $collection->add(0, $class);

        $actual = $collection->get(0);

        $this->assertInstanceOf($type, $actual);
        $this->assertSame($class, $actual);
    }

    /**
     * Test constructor with a TypeInterface implementation.
     *
     * This test ensures that the collection properly validates values
     * when using a TypeInterface implementation to define type constraints.
     *
     * @throws InvalidArgumentException If an invalid argument is provided.
     */
    public function testConstructorWithTypeInterface(): void
    {
        $stringType = new StringType();
        $collection = new GenericCollection($stringType);

        $this->assertTrue($collection->validate("some value"));
        $this->assertFalse($collection->validate(1));
        $this->assertFalse($collection->validate([]));
        $this->assertFalse($collection->validate(false));
        $this->assertFalse($collection->validate(null));
        $this->assertFalse($collection->validate(new class {}));
    }

    /**
     * Test constructor with a Closure type validator.
     *
     * This test checks that a Closure used as a type validator can be
     * successfully applied to values in the collection.
     *
     * @throws InvalidArgumentException If an invalid argument is provided.
     */
    public function testConstructorWithClosure(): void
    {
        $typeValidator = fn($value): bool => $value === true;
        $collection = new GenericCollection($typeValidator);

        $this->assertTrue($collection->validate(true));
        $this->assertFalse($collection->validate(false));
        $this->assertFalse($collection->validate(1));
    }
}
