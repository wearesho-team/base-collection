<?php

declare(strict_types=1);

namespace Wearesho\Tests\Unit\Mock;

use Wearesho\BaseCollection;

/** @extends BaseCollection<\stdClass> */
class StdCollectionMock extends BaseCollection
{
    public function type(): string
    {
        return \stdClass::class;
    }
}
