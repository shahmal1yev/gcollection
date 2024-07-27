<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\ObjectType;
use PHPUnit\Framework\TestCase;
use stdClass;

class ObjectTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the ObjectType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new ObjectType();
    }

    /**
     * Test validate method with an object.
     *
     * This test ensures that the validate method returns true when
     * given an object (such as an instance of stdClass).
     */
    public function testValidateWithObject(): void
    {
        $this->assertTrue($this->type->validate(new stdClass()));
    }

    /**
     * Test validate method with non-object values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not objects.
     */
    public function testValidateWithNonObject(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1));
        $this->assertFalse($this->type->validate(2.3));
        $this->assertFalse($this->type->validate([]));
        $this->assertFalse($this->type->validate(true));
    }

    /**
     * Test the string representation of the ObjectType.
     *
     * This test checks that the string conversion of the ObjectType
     * returns the expected string "object".
     */
    public function testToString(): void
    {
        $expected = "object";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if ObjectType implements TypeInterface.
     *
     * This test ensures that ObjectType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
