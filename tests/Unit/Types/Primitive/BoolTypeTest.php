<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\BoolType;
use PHPUnit\Framework\TestCase;
use stdClass;

class BoolTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the BoolType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new BoolType();
    }

    /**
     * Test validate method with a boolean value.
     *
     * This test ensures that the validate method returns true when
     * given a boolean value.
     */
    public function testValidateWithBool(): void
    {
        $this->assertTrue($this->type->validate(true));
    }

    /**
     * Test validate method with non-boolean values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not of type boolean.
     */
    public function testValidateWithNonBool(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1.2));
        $this->assertFalse($this->type->validate(new stdClass()));
        $this->assertFalse($this->type->validate([]));
    }

    /**
     * Test the string representation of the BoolType.
     *
     * This test checks that the string conversion of the BoolType
     * returns the expected string "bool".
     */
    public function testToString(): void
    {
        $expected = "bool";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if BoolType implements TypeInterface.
     *
     * This test ensures that BoolType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
