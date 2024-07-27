<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\IntType;
use PHPUnit\Framework\TestCase;
use stdClass;

class IntTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the IntType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new IntType();
    }

    /**
     * Test validate method with an integer value.
     *
     * This test ensures that the validate method returns true when
     * given an integer value.
     */
    public function testValidateWithInt(): void
    {
        $this->assertTrue($this->type->validate(1));
    }

    /**
     * Test validate method with non-integer values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not integers.
     */
    public function testValidateWithNonInt(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1.2));
        $this->assertFalse($this->type->validate(new stdClass()));
        $this->assertFalse($this->type->validate([]));
        $this->assertFalse($this->type->validate(true));
    }

    /**
     * Test the string representation of the IntType.
     *
     * This test checks that the string conversion of the IntType
     * returns the expected string "integer".
     */
    public function testToString(): void
    {
        $expected = "integer";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if IntType implements TypeInterface.
     *
     * This test ensures that IntType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
