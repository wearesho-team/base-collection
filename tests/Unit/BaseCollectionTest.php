<?php

namespace Wearesho\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wearesho\BaseCollection;

/**
 * Class BaseCollectionTest
 * @package Wearesho\Tests\Unit
 * @coversDefaultClass \Wearesho\BaseCollection
 * @internal
 */
class BaseCollectionTest extends TestCase
{
    /** @var BaseCollection */
    protected $fakeBaseCollection;

    protected function setUp()
    {
        $this->fakeBaseCollection = new class extends BaseCollection
        {
            public function type(): string
            {
                return \stdClass::class;
            }
        };
    }

    public function testGetType(): void
    {
        $this->assertEquals(\stdClass::class, $this->fakeBaseCollection->type());
    }

    public function testSuccessInstantiate(): void
    {
        $this->assertEmpty($this->fakeBaseCollection);
        $this->assertCount(0, $this->fakeBaseCollection);

        $elements = [
            new \stdClass(),
            new \stdClass(),
        ];
        $this->fakeBaseCollection = new $this->fakeBaseCollection($elements);

        $this->assertNotEmpty($this->fakeBaseCollection);
        $this->assertCount(2, $this->fakeBaseCollection);
    }

    public function testFailedInstantiate(): void
    {
        $this->assertEmpty($this->fakeBaseCollection);
        $this->assertCount(0, $this->fakeBaseCollection);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Element Exception must be instance of stdClass');

        $this->fakeBaseCollection = new $this->fakeBaseCollection([new \Exception()]);
    }

    public function testSuccessAppend(): void
    {
        $this->assertEmpty($this->fakeBaseCollection);
        $this->assertCount(0, $this->fakeBaseCollection);

        $this->fakeBaseCollection->append(new \stdClass());
        $this->fakeBaseCollection->append(new \stdClass());
        $this->fakeBaseCollection->append(new \stdClass());

        $this->assertNotEmpty($this->fakeBaseCollection);
        $this->assertCount(3, $this->fakeBaseCollection);

        $this->fakeBaseCollection
            ->append(new \stdClass())
            ->append(new \stdClass())
            ->append(new \stdClass());

        $this->assertCount(6, $this->fakeBaseCollection);
    }

    public function testFailedAppend(): void
    {
        $this->assertEmpty($this->fakeBaseCollection);
        $this->assertCount(0, $this->fakeBaseCollection);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Element Exception must be instance of stdClass');

        $this->fakeBaseCollection->append(new \Exception());
    }

    public function testSuccessOffsetSet(): void
    {
        $this->assertEmpty($this->fakeBaseCollection);
        $this->assertCount(0, $this->fakeBaseCollection);

        $this->fakeBaseCollection->offsetSet(0, new \stdClass());
        $this->fakeBaseCollection->offsetSet('key', new \stdClass());
        $this->fakeBaseCollection->offsetSet(1, new \stdClass());

        $this->assertNotEmpty($this->fakeBaseCollection);
        $this->assertCount(3, $this->fakeBaseCollection);
        $this->assertArrayHasKey(0, $this->fakeBaseCollection);
        $this->assertArrayHasKey('key', $this->fakeBaseCollection);
        $this->assertArrayHasKey(1, $this->fakeBaseCollection);
    }

    public function testFailedOffsetSet(): void
    {
        $this->assertEmpty($this->fakeBaseCollection);
        $this->assertCount(0, $this->fakeBaseCollection);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Element Exception must be instance of stdClass');

        $this->fakeBaseCollection->offsetSet(0, new \Exception());
    }

    public function testJsonSerialize(): void
    {
        $this->fakeBaseCollection
            ->append(new \stdClass())
            ->append(new \stdClass())
            ->append(new \stdClass());

        $this->assertArraySubset(
            [
                new \stdClass(),
                new \stdClass(),
                new \stdClass(),
            ],
            $this->fakeBaseCollection->jsonSerialize()
        );
    }

    public function testExchangeArray(): void
    {
        $this->fakeBaseCollection
            ->append(new \stdClass())
            ->append(new \stdClass())
            ->append(new \stdClass());

        $newData = [
            new \stdClass(),
            new \stdClass(),
            new \stdClass(),
        ];

        foreach ($newData as $newDatum) {
            $newDatum->value = \mt_rand();
        }

        $oldCollection = $this->fakeBaseCollection->exchangeArray($newData);

        $this->assertEquals(
            [
                new \stdClass(),
                new \stdClass(),
                new \stdClass(),
            ],
            $oldCollection
        );
        $this->assertNotNull($this->fakeBaseCollection[0]->value);
        $this->assertNotNull($this->fakeBaseCollection[1]->value);
        $this->assertNotNull($this->fakeBaseCollection[2]->value);
    }

    public function testFAiledExchangeArray(): void
    {
        $this->fakeBaseCollection
            ->append(new \stdClass())
            ->append(new \stdClass())
            ->append(new \stdClass());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Input must be an iterable element');

        $this->fakeBaseCollection->exchangeArray("invalid data");
    }

    public function testJsonSerializeWithProperties(): void
    {
        $collection = new class extends BaseCollection
        {
            /** @var string */
            protected $value = 'test-value';

            public function type(): string
            {
                return \stdClass::class;
            }

            public function jsonSerialize(): array
            {
                return [
                    'value' => $this->value,
                    'elements' => parent::jsonSerialize()
                ];
            }
        };

        $collection
            ->append(new \stdClass())
            ->append(new \stdClass())
            ->append(new \stdClass());

        $this->assertArraySubset(
            [
                'value' => 'test-value',
                'elements' => [
                    new \stdClass(),
                    new \stdClass(),
                    new \stdClass(),
                ],
            ],
            $collection->jsonSerialize()
        );
    }
}
