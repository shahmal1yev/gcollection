<?php

namespace Tests\Unit\Types\Primitive;

use GenericCollection\Interfaces\TypeInterface;
use GenericCollection\Types\Primitive\ResourceType;
use PHPUnit\Framework\TestCase;

class ResourceTypeTest extends TestCase
{
    private TypeInterface $type;

    /**
     * Set up the test environment.
     *
     * Initializes the ResourceType instance to be used in the tests.
     */
    public function setUp(): void
    {
        $this->type = new ResourceType();
    }

    /**
     * Test validate method with a resource.
     *
     * This test ensures that the validate method returns true when
     * given a valid resource (such as a file resource).
     */
    public function testValidateWithResource(): void
    {
        $resource = fopen('php://temp', 'r+');
        $this->assertTrue($this->type->validate($resource));
        fclose($resource);
    }

    /**
     * Test validate method with non-resource values.
     *
     * This test verifies that the validate method returns false when
     * given values that are not resources.
     */
    public function testValidateWithNonResource(): void
    {
        $this->assertFalse($this->type->validate("some value"));
        $this->assertFalse($this->type->validate(1));
        $this->assertFalse($this->type->validate(2.3));
        $this->assertFalse($this->type->validate([]));
        $this->assertFalse($this->type->validate(true));
        $this->assertFalse($this->type->validate(new class {}));
    }

    /**
     * Test the string representation of the ResourceType.
     *
     * This test checks that the string conversion of the ResourceType
     * returns the expected string "resource".
     */
    public function testToString(): void
    {
        $expected = "resource";
        $actual = (string) $this->type;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test if ResourceType implements TypeInterface.
     *
     * This test ensures that ResourceType implements the TypeInterface.
     */
    public function testInstanceOfTypeInterface(): void
    {
        $expected = TypeInterface::class;
        $actual = $this->type;

        $this->assertInstanceOf($expected, $actual);
    }
}
