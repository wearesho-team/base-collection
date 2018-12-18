<?php

namespace Wearesho\Tests\Mock;

/**
 * Class Element
 * @package Wearesho\Tests\Mock
 */
class Element
{
    /** @var mixed */
    public $value;

    /**
     * Element constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}
