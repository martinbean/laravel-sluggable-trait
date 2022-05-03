# Laravel Sluggable Trait

A trait you can apply to Eloquent models to have slugs automatically generated on save.

## Installation

```
composer require martinbean/laravel-sluggable-trait
```

## Usage

```php
<?php

namespace App\Models;

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

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MartinBean\Database\Eloquent\Sluggable;

class Item extends Model
{
    use Sluggable;

    protected function getSlugColumnName()
    {
        return 'seo_title';
    }

    protected function getSluggableString()
    {
        return 'headline';
    }
}

```
**Note:** The visibility of these methods changed from `public` to `protected` in version 0.4.0 of this package.

The `getSlugColumnName()` method should return the name of the column you want
to store slugs in your database table.

The `getSluggableString()` should return a string you want to create a slug
from. This is exposed as a method and not a property or constantly as you may
want to create a slug from the value of one than one column. For example:

```php
/**
 * Create a string based on the first and last name of a person.
 */
protected function getSluggableString()
{
    return sprintf('%s %s', $this->first_name, $this->last_name);
}
```

```php
/**
 * Create a string based on a formatted address string.
 */
protected function getSluggableString()
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

### Configuration
By default, the package will use dashes as word separators in slugs, i.e. `this-is-your-slug`. The separator character can be changed by publishing the package’s configuration file and specifying your own separator character.

```
php artisan vendor:publish --tag=sluggable-config
```

You can then change the separator value to something like an underscore in the published **config/sluggable.php** file:

```php
<?php
// config/sluggable.php

return [

    'separator' => '_',

];
```

**Note:** Changing the slug separator _won’t_ change any existing slugs in your database. You’ll need to update those manually if you change the separator.

## License

Licensed under the [MIT Licence](LICENSE.md).
