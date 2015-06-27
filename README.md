# Laravel Sluggable Trait

A trait you can apply to Eloquent models to have slugs automatically generated on save.

<br>

## Installation

    $ composer require martinbean/laravel-sluggable-trait

<br>
## Usage

    <?php namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    use MartinBean\Database\Elouqent\Sluggable;
    
    class Item extends Model {
    
    	use Sluggable;
    
    }
    

By default, the trait assumes your database has two columns: `name` and `slug`.
If you need to change these, you can do so via class constants:

    
    <?php namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    use MartinBean\Database\Elouqent\Sluggable;
    
    class Item extends Model {
    
    	use Sluggable;
    
    	const SLUGGABLE_SLUG_COLUMN = 'headline';
    	const SLUGGABLE_NAME_COLUMN = 'seo_url';
    
    }
    
<br>
### Regenerating Slugs ###
By default, the trait will not overwrite slugs if there is already a value in the model's slug column. To override, this feature, the slug column should be set to null prior to calling the model's save function. E.g.

    $mymodel->myslugcolumn = '';
    $mymodel->save();


<br>
### Unique Slugs ###

The trait supports the generation of unique traits by adding a hexidecimal counter to the end of the slug name if the slug already exists. The counter can also be prefixed with a static OR dynamically generated value. To use a static prefix on the counter, in your model use:

    
    <?php namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    use MartinBean\Database\Elouqent\Sluggable;
    
    class Item extends Model {
    
    	use Sluggable;
    
    	const SLUGGABLE_SLUG_COLUMN = 'headline';
    	const SLUGGABLE_NAME_COLUMN = 'seo_url';
		const SLUGGABLE_UNIQUE_PREFIXER = 'news';

    }
    
To generate a runtime prefix to prepend to the slug counter when generating a unique slug, you may define a function *sluggableUniquePrefixer* in your model code that may return a value, based on your model's values. For example:


    <?php namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    use MartinBean\Database\Elouqent\Sluggable;
    
    class Item extends Model {
    
    	use Sluggable;
    
    	const SLUGGABLE_SLUG_COLUMN = 'headline';
    	const SLUGGABLE_NAME_COLUMN = 'seo_url';
		// SLUGGABLE_UNIQUE_PREFIXER will be ignored if a sluggableUniquePrefixer method is present
		const SLUGGABLE_UNIQUE_PREFIXER = 'news';  


	    public function sluggableUniquePrefixer() {
	        if ($this->author)
	            return substr($this->author->firstName,0,1).substr($this->author->lastName,0,1);
	        return '';
	    }

    }



<br>

## License

Licensed under the [MIT Licence](LICENSE.md).
