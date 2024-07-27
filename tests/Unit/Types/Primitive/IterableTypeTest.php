<?php

namespace Tests\Unit\Types\Primitive;

use ArrayIterator;
use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\IterableType;
use PHPUnit\Framework\TestCase;

class IterableTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the IterableType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new IterableType();
    }

    /**
     * Test validate method with an iterable value.
     *
     * This test ensures that the validate method returns true when
     * given an iterable value (such as an ArrayIterator).
     */
    public function testValidateWithIterable(): void
    {
        $this->assertTrue($this->type->validate(new ArrayIterator([])));
    }

    /**
     * Test validate method with non-iterable values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not iterable.
     */
    public function testValidateWithNonIterable(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1));
        $this->assertFalse($this->type->validate(true));
    }

    /**
     * Test the string representation of the IterableType.
     *
     * This test checks that the string conversion of the IterableType
     * returns the expected string "iterable".
     */
    public function testToString(): void
    {
        $expected = "iterable";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if IterableType implements TypeInterface.
     *
     * This test ensures that IterableType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
