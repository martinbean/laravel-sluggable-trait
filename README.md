# Laravel Sluggable Trait

A trait you can apply to Eloquent models to have slugs automatically generated on save.

## Installation

    $ composer require martinbean/laravel-sluggable-trait

## Usage

```php
<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use MartinBean\Database\Elouqent\Sluggable;

class Item extends Model {

	use Sluggable;

}
```

By default, the trait assumes your database has two columns: `name` and `slug`.
If you need to change these, you can do so via class constants:

```php
<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use MartinBean\Database\Elouqent\Sluggable;

class Item extends Model {

	use Sluggable;

	const DISPLAY_NAME = 'headline';
	const SLUG = 'seo_url';

}
```

## License

Licensed under the [MIT Licence](LICENSE.md).
