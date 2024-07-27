<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\FloatType;
use PHPUnit\Framework\TestCase;
use stdClass;

class FloatTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the FloatType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new FloatType();
    }

    /**
     * Test validate method with a float value.
     *
     * This test ensures that the validate method returns true when
     * given a float value.
     */
    public function testValidateWithFloat(): void
    {
        $this->assertTrue($this->type->validate(1.3));
    }

    /**
     * Test validate method with non-float values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not floats.
     */
    public function testValidateWithNonFloat(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1));
        $this->assertFalse($this->type->validate(new stdClass()));
        $this->assertFalse($this->type->validate([]));
        $this->assertFalse($this->type->validate(true));
    }

    /**
     * Test the string representation of the FloatType.
     *
     * This test checks that the string conversion of the FloatType
     * returns the expected string "float".
     */
    public function testToString(): void
    {
        $expected = "float";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if FloatType implements TypeInterface.
     *
     * This test ensures that FloatType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
