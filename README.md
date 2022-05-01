# Laravel Sluggable Trait

A trait you can apply to Eloquent models to have slugs automatically generated on save.  
This is a slight improvement on
[martinbean/laravel-sluggable-trait](https://github.com/martinbean/laravel-sluggable-trait)
to allow the slug character to be changed from dash to underscore (by default)
or any character of your choice.

## Installation

    $ composer require mvnrsa/laravel-sluggable-trait

## Usage

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use mvnrsa\Database\Eloquent\Sluggable;

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
use mvnrsa\Database\Eloquent\Sluggable;

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

The `getSlugCharacter()` should return the character you want to use as
replacement in slugs.  Default is dash (-).

```php
/**
 * Allows overriding the character used in slugs.
 */
public function getSlugCharacter()
{
	return '_';
}
```

## License

Licensed under the [MIT Licence](LICENSE.md).
