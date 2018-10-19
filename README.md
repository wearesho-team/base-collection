# Base Сollection

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

If you will try append item that not instance of your type you will catch an `InvalidArgumentException`

## Authors

- [Roman <KartaviK> Varkuta](mailto:roman.varkuta@gmail.com) 
- [Alexander <Horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)

