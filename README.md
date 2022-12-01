# Base Сollection
[![PHP Composer](https://github.com/wearesho-team/base-collection/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/wearesho-team/base-collection/actions/workflows/php.yml)
[![Latest Stable Version](https://poser.pugx.org/wearesho-team/base-collection/v/stable.png)](https://packagist.org/packages/wearesho-team/base-collection)
[![Total Downloads](https://poser.pugx.org/wearesho-team/base-collection/downloads.png)](https://packagist.org/packages/wearesho-team/base-collection)
[![codecov](https://codecov.io/gh/wearesho-team/base-collection/branch/master/graph/badge.svg?token=Rsbqe2LmqZ)](https://codecov.io/gh/wearesho-team/base-collection)

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
        return stdClass::class;
    }
}
```

And now you have typed collection!

If you try to append item that not instance of your type you will catch an `InvalidArgumentException`

## Authors

- [Roman <KartaviK> Varkuta](mailto:roman.varkuta@gmail.com) 
- [Alexander <Horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)

