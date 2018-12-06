<?php

namespace Wearesho;

/**
 * Class BaseCollection
 * @package Wearesho
 */
abstract class BaseCollection extends \ArrayObject implements \JsonSerializable
{
    /**
     * @param array $elements
     * @param int $flags
     * @param string $iteratorClass
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $elements = [], int $flags = 0, string $iteratorClass = \ArrayIterator::class)
    {
        foreach ($elements as $element) {
            $this->validate($element);
        }

        parent::__construct($elements, $flags, $iteratorClass);
    }

    /**
     * Override to customize type of your collection.
     * Must return declared class name
     *
     * @return string
     */
    abstract public function type(): string;

    /**
     * @param mixed $value
     *
     * @return BaseCollection|static
     * @throws \InvalidArgumentException
     */
    public function append($value): BaseCollection
    {
        $this->validate($value);

        parent::append($value);

        return $this;
    }

    /**
     * @param mixed $index
     * @param mixed $value
     *
     * @return BaseCollection|static
     * @throws \InvalidArgumentException
     */
    public function offsetSet($index, $value): BaseCollection
    {
        $this->validate($value);

        parent::offsetSet($index, $value);

        return $this;
    }

    public function jsonSerialize(): array
    {
        return (array)$this;
    }

    /**
     * @param \Closure $callback
     *
     * @return int|float|double
     */
    public function sum(\Closure $callback)
    {
        return array_sum(array_map($callback, (array)$this));
    }

    /**
     * @param mixed $object
     *
     * @throws \InvalidArgumentException
     */
    protected function validate($object): void
    {
        $needType = $this->type();

        if (!$object instanceof $needType) {
            throw new \InvalidArgumentException("Element " . get_class($object) . " must be instance of " . $needType);
        }
    }
}
