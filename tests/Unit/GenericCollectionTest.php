<?php

namespace Tests\Unit;

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
    private TypeInterface $mockType;
    private GenericCollection $genericCollection;

    /**
     * Set up the test environment.
     *
     * @throws InvalidArgumentException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockType = $this->createMock(TypeInterface::class);
        $this->genericCollection = new GenericCollection($this->mockType);
    }

    /**
     * Test constructor with a valid array.
     *
     * @throws InvalidArgumentException
     */
    public function testConstructorWithValidArray(): void
    {
        $content = [1, 2, 3];
        $intType = new IntType();

        $collection = new GenericCollection($intType, $content);

        $this->assertEquals($content, $collection->toArray());
    }

    /**
     * Test constructor with an invalid array.
     *
     * @throws InvalidArgumentException
     */
    public function testConstructorWithInvalidArray(): void
    {
        $content = [1, 2, 3, "invalid item"];
        $intType = new IntType();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("'\$value' is not of type %s.", IntType::class));

        new GenericCollection($intType, $content);
    }

    /**
     * Test validate method returns true with a valid item.
     */
    public function testValidateReturnsTrueWithValidItem(): void
    {
        $this->mockType->method('validate')->willReturn(true);
        $this->assertTrue($this->genericCollection->validate('some value'));
    }

    /**
     * Test validate method returns false with an invalid item.
     */
    public function testValidateReturnsFalseWithInvalidItem(): void
    {
        $this->mockType->method('validate')->willReturn(false);
        $this->assertFalse($this->genericCollection->validate([]));
    }

    /**
     * Test validateWithException method throws an exception with an invalid item.
     *
     * @throws InvalidArgumentException
     */
    public function testValidateWithExceptionThrowsException(): void
    {
        $type = new StringType();
        $this->genericCollection = new GenericCollection($type);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("'\$value' is not of type %s.", StringType::class));

        $this->genericCollection->validateWithException([]);
    }

    /**
     * Test validateWithException method does not throw an exception with a valid item.
     *
     * @throws InvalidArgumentException
     */
    public function testValidateWithExceptionNotThrowsException(): void
    {
        $this->genericCollection = new GenericCollection(new StringType());
        $this->assertNull($this->genericCollection->validateWithException("some value"));
    }

    /**
     * Test offsetExists method returns true with an existing offset.
     *
     * @throws InvalidArgumentException
     */
    public function testOffsetExistsReturnsTrueWithAvailableItem(): void
    {
        $this->mockType->method('validate')->willReturn(true);
        $this->genericCollection->add(12, "some value");
        $this->assertTrue($this->genericCollection->offsetExists(12));
    }

    /**
     * Test offsetExists method returns false with a non-existing offset.
     */
    public function testOffsetExistsReturnsFalseWithUnavailableItem(): void
    {
        $this->assertFalse($this->genericCollection->offsetExists(0));
        $this->assertFalse($this->genericCollection->offsetExists(1));
        $this->assertFalse($this->genericCollection->offsetExists("key"));
    }

    /**
     * Test offsetGet method returns the correct item.
     *
     * @throws UndefinedOffsetException
     * @throws InvalidArgumentException
     */
    public function testOffsetGetReturnsCorrectItem(): void
    {
        $this->mockType->method('validate')->willReturn(true);

        $this->genericCollection->add('key 3', []);
        $this->genericCollection->add('key 2', true);
        $this->genericCollection->add('key 1', false);
        $this->genericCollection->add(0, null);

        $this->assertEquals([], $this->genericCollection->offsetGet('key 3'));
        $this->assertEquals(true, $this->genericCollection->offsetGet('key 2'));
        $this->assertEquals(false, $this->genericCollection->offsetGet('key 1'));
        $this->assertEquals(null, $this->genericCollection->offsetGet(0));
    }

    /**
     * Test offsetGet method throws an exception with an invalid offset.
     */
    public function testOffsetGetThrowsExceptionWithInvalidOffset(): void
    {
        $undefinedOffset = 0;

        $this->expectException(UndefinedOffsetException::class);
        $this->expectExceptionMessage("Offset $undefinedOffset does not exist.");

        $this->genericCollection->offsetGet($undefinedOffset);
    }

    /**
     * Test offsetSet method works with falsy values.
     *
     * @throws InvalidArgumentException
     * @throws UndefinedOffsetException
     */
    public function testOffsetSetFalsyValues(): void
    {
        $this->mockType->method("validate")->willReturn(true);

        $falsyValues = [null, false, 0, 0.0, "0", "", []];

        foreach ($falsyValues as $index => $falsyValue) {
            $this->genericCollection->offsetSet($index, $falsyValue);

            $this->assertSame($falsyValue, $this->genericCollection->offsetGet($index));
        }
    }

    /**
     * Test offsetSet method updates the value at an existing offset.
     *
     * @throws InvalidArgumentException
     * @throws UndefinedOffsetException
     */
    public function testOffsetSetUpdatesValueAtAvailableOffset(): void
    {
        $this->mockType->method('validate')->willReturn(true);

        $value = "some value 1";
        $expectedValue = "some value 2";
        $offset = 21;

        $this->genericCollection->offsetSet($offset, $value);
        $this->genericCollection->offsetSet($offset, $expectedValue);

        $this->assertSame($expectedValue, $this->genericCollection->offsetGet($offset));
    }

    /**
     * Test offsetSet method throws an exception with an invalid item.
     *
     * @throws InvalidArgumentException
     */
    public function testOffsetSetThrowsExceptionOnInvalidItem(): void
    {
        $stringType = new StringType();
        $this->genericCollection = new GenericCollection($stringType);

        $invalidValue = null;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf("'\$value' is not of type %s.", StringType::class));

        $this->genericCollection->offsetSet(0, $invalidValue);
    }

    /**
     * Test offsetUnset method works with falsy values.
     *
     * @throws InvalidArgumentException
     */
    public function testOffsetUnsetWithFalsyValues(): void
    {
        $this->mockType->method('validate')->willReturn(true);

        $falsyValues = [null, false, 0, 0.0, "0", "", []];

        foreach ($falsyValues as $index => $falsyValue) {
            $this->assertFalse($this->genericCollection->offsetExists($index));

            $this->genericCollection->offsetSet($index, $falsyValue);

            $this->assertTrue($this->genericCollection->offsetExists($index));

            $this->genericCollection->offsetUnset($index);

            $this->assertFalse($this->genericCollection->offsetExists($index));
        }
    }

    /**
     * Test toArray method returns an empty array.
     */
    public function testToArrayReturnsEmptyArray(): void
    {
        $this->assertEmpty($this->genericCollection->toArray());
    }

    /**
     * Test toArray method returns a non-empty array.
     *
     * @throws InvalidArgumentException
     */
    public function testToArrayReturnsNonEmptyArray(): void
    {
        $intType = new IntType();
        $content = [1, 2, 3];

        $this->genericCollection = new GenericCollection($intType, $content);

        $this->assertEquals($content, $this->genericCollection->toArray());
    }

    /**
     * Test getIterator method returns an instance of ArrayIterator.
     *
     * @throws InvalidArgumentException
     */
    public function testGetIteratorReturnsInstanceOfArrayIterator(): void
    {
        $this->assertInstanceOf(ArrayIterator::class, $this->genericCollection->getIterator());
    }

    /**
     * Test GenericCollection class implements Countable.
     */
    public function testGenericCollectionImplementsCountable(): void
    {
        $this->assertInstanceOf(Countable::class, $this->genericCollection);
    }

    /**
     * Test count method returns the correct count.
     *
     * @throws InvalidArgumentException
     */
    public function testCountReturnsCorrectCount(): void
    {
        $intType = new IntType();
        $this->genericCollection = new GenericCollection($intType);

        $expectedCount = 3;
        for ($i = 0; $i < $expectedCount; $i++) {
            $this->genericCollection->offsetSet($i, $i);
        }

        $this->assertSame($expectedCount, $this->genericCollection->count());
    }
}
