<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\StringType;
use PHPUnit\Framework\TestCase;
use stdClass;

class StringTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the StringType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new StringType();
    }

    /**
     * Test validate method with string values.
     *
     * This test ensures that the validate method returns true when
     * given valid string values, including a string representation of
     * the type itself.
     */
    public function testValidateWithString(): void
    {
        $this->assertTrue($this->type->validate((string) $this->type));
        $this->assertTrue($this->type->validate("some string"));
        $this->assertTrue($this->type->validate("1"));
    }

    /**
     * Test validate method with non-string values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not strings.
     */
    public function testValidateWithNonString(): void
    {
        $this->assertFalse($this->type->validate(1));
        $this->assertFalse($this->type->validate(1.2));
        $this->assertFalse($this->type->validate(new stdClass()));
        $this->assertFalse($this->type->validate([]));
        $this->assertFalse($this->type->validate(true));
    }

    /**
     * Test the string representation of the StringType.
     *
     * This test checks that the string conversion of the StringType
     * returns the expected string "string".
     */
    public function testToString(): void
    {
        $expected = "string";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if StringType implements TypeInterface.
     *
     * This test ensures that StringType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
