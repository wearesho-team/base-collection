<?php

namespace Wearesho\Tests\Mock;

use Wearesho\BaseCollection;

/**
 * Class Collection
 * @package Wearesho\Tests\Mock
 */
class Collection extends BaseCollection
{
    public function type(): string
    {
        return Element::class;
    }
}
