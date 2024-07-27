<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\CallableType;
use PHPUnit\Framework\TestCase;

class CallableTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the CallableType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new CallableType();
    }

    /**
     * Test validate method with a callable value.
     *
     * This test ensures that the validate method returns true when
     * given a callable value (e.g., a function or closure).
     */
    public function testValidateWithCallable(): void
    {
        $this->assertTrue($this->type->validate(fn () => true));
    }

    /**
     * Test validate method with non-callable values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not callable.
     */
    public function testValidateWithNonCallable(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1));
        $this->assertFalse($this->type->validate(2.3));
        $this->assertFalse($this->type->validate([]));
        $this->assertFalse($this->type->validate(true));
    }

    /**
     * Test the string representation of the CallableType.
     *
     * This test checks that the string conversion of the CallableType
     * returns the expected string "callable".
     */
    public function testToString(): void
    {
        $expected = "callable";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if CallableType implements TypeInterface.
     *
     * This test ensures that CallableType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
