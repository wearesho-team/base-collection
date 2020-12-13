<?php

declare(strict_types=1);

namespace Wearesho;

/**
 * Class BaseCollection
 * @package Wearesho
 *
 * @template T of object
 * @extends \ArrayObject<array-key, T>
 */
abstract class BaseCollection extends \ArrayObject implements \JsonSerializable
{
    /**
     * @psalm-param iterable<array-key, T> $elements
     * @param int $flags
     * @phpstan-param class-string<\ArrayIterator<array-key, T>> $iteratorClass
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(iterable $elements = [], int $flags = 0, string $iteratorClass = \ArrayIterator::class)
    {
        $validatedItems = [];

        foreach ($elements as $key => $element) {
            $this->validate($element);

            $validatedItems[$key] = $element;
        }

        parent::__construct($validatedItems, $flags, $iteratorClass);
    }

    /**
     * Override to customize type of your collection.
     * Must return declared class name
     *
     * @return class-string<T>
     */
    abstract public function type(): string;

    /**
     * @param T $value
     *
     * @return self<T>
     * @throws \InvalidArgumentException
     */
    public function append($value): self
    {
        $this->validate($value);

        parent::append($value);

        return $this;
    }

    /**
     * @param array-key $index
     * @param T         $value
     *
     * @return self<T>
     * @throws \InvalidArgumentException
     */
    public function offsetSet($index, $value): self
    {
        $this->validate($value);

        parent::offsetSet($index, $value);

        return $this;
    }

    /**
     * @param iterable<array-key, T> $input
     *
     * @return array<array-key, T>
     */
    public function exchangeArray($input): array
    {
        if (!\is_iterable($input)) {
            throw new \InvalidArgumentException("Input must be an iterable element");
        }

        foreach ($input as $item) {
            $this->validate($item);
        }

        /** @phpstan-var array<array-key, T> $arr */
        $arr = parent::exchangeArray((array) $input);

        return $arr;
    }

    /**
     * @return array<array-key, T>
     */
    public function jsonSerialize(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @param T $object
     *
     * @throws \InvalidArgumentException
     */
    protected function validate($object): void
    {
        $needType = $this->type();

        if (!$object instanceof $needType) {
            throw new \InvalidArgumentException("Element " . \get_class($object) . " must be instance of " . $needType);
        }
    }
}
