<?php namespace MartinBean\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable {

	/**
	 * Boot the sluggable trait for a model.
	 *
	 * @return void
	 */
	public static function bootSluggable()
	{
		$name = static::getDisplayNameColumn();
		$slug = static::getSlugColumn();

		$callback = function(Model $model) use ($name, $slug)
		{
            // Generate a unique slug, only if the slug is not already set
            if ($model->slug == '') {
                $workingSlug = Str::slug($model->$name);
                $workingModel = clone $model; // work with a cloned copy of the model for testing existing slugs
                $count = 0;
                while ($row = $workingModel->where($slug, '=', $workingSlug)->first()) {
                    $count += 1;
                    $workingSlug = Str::slug($model->$name . self::getSlugUniquePrefixer($model) . dechex($count));
                }
                $model->$slug = $workingSlug;
            }
		};

		static::registerModelEvent('saving', $callback, 0);
	}

	/**
	 * Get the name of the display name column.
	 *
	 * @return string
	 */
	public static function getDisplayNameColumn()
	{
		return defined('static::SLUGGABLE_NAME_COLUMN') ? static::SLUGGABLE_NAME_COLUMN : 'name';
	}

	/**
	 * Get the name of the slug column.
	 *
	 * @return string
	 */
	public static function getSlugColumn()
	{
		return defined('static::SLUGGABLE_SLUG_COLUMN') ? static::SLUGGABLE_SLUG_COLUMN : 'slug';
	}

    /**
     * Get the name of the slug prefix to prepend to incrementer.
     *
     * @return string
     */
    public static function getSlugUniquePrefixer(Model $model)
    {
        // The model may have a function defined that returns a dynamic prefix for the uniquely generated slug
        if (method_exists($model, 'sluggableUniquePrefixer')) {
            debug($model->sluggableUniquePrefixer());
            return $model->sluggableUniquePrefixer();
        }
        return defined('static::SLUGGABLE_UNIQUE_PREFIXER') ? static::SLUGGABLE_UNIQUE_PREFIXER : '';
    }

}
