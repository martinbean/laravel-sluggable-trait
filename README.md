# Laravel Sluggable Trait

A trait you can apply to Eloquent models to have slugs automatically generated on save.

## Installation

    $ composer require martinbean/laravel-sluggable-trait

## Usage

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MartinBean\Database\Eloquent\Sluggable;

class Item extends Model
{
    use Sluggable;
}
```

By default, the trait assumes your database has two columns: `name` and `slug`.
If you need to change these, you can override the getter methods:

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MartinBean\Database\Eloquent\Sluggable;

class Item extends Model
{
    use Sluggable;

    public function getSlugColumnName()
    {
        return 'seo_title';
    }

    public function getSluggableString()
    {
        return 'headline';
    }
}
```

The `getSlugColumnName()` method should return the name of the column you want
to store slugs in your database table.

The `getSluggableString()` should return a string you want to create a slug
from. This is exposed as a method and not a property or constantly as you may
want to create a slug from the value of one than one column. For example:

```php
/**
 * Create a string based on the first and last name of a person.
 */
public function getSluggableString()
{
    return sprintf('%s %s', $this->first_name, $this->last_name);
}
```

```php
/**
 * Create a string based on a formatted address string.
 */
public function getSluggableString()
{
    return implode(', ', array_filter([
        $this->street_address,
        $this->locality,
        $this->region,
        $this->postal_code,
        $this->country,
    ]));
}
```

## License

Licensed under the [MIT Licence](LICENSE.md).
