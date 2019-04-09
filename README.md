# Base Сollection
[![Build Status](https://travis-ci.org/wearesho-team/base-collection.svg?branch=master)](https://travis-ci.org/wearesho-team/base-collection)
[![codecov](https://codecov.io/gh/wearesho-team/base-collection/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/base-collection)

Implementation of typed collection.

## Installation

```bash
composer require wearesho-team/base-collection
```

## Usage

Create your class collection and implement `type()` method.

It must return declared (existed) class name

```php
<?php

use Wearesho\BaseCollection;

class MyCollection extends BaseCollection
{
    public function type(): string
    {
        return \stdClass::class;
    }
}
```

And now you have typed collection!

If you will try append item that not instance of your type you will catch an `InvalidArgumentException`

### Additional methods

- `sum(\Closure $callback): int|float`
```php
<?php

use Wearesho\BaseCollection;

/** @var BaseCollection $collection */
$collection = new MyCollection([
    new \stdClass(),
    new \stdClass(),
    new \stdClass(),
]);

$sum = $collection->sum(function (\stdClass $item) {
    return mb_strlen(get_class($item)); // 8
}); // 24
```

- `map(\Closure $callback): array`
```php
<?php

/** @var \Wearesho\BaseCollection $collection */
$collection = new MyCollection([
    new \stdClass(),
    new \stdClass(),
]);

$collection->map(function (\stdClass $obj) {
    return mb_strcut(get_class($obj), 0, 2);
});

// ['st', 'st',]
```

## Authors

- [Roman <KartaviK> Varkuta](mailto:roman.varkuta@gmail.com) 
- [Alexander <Horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)

