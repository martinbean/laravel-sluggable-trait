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
			$model->$slug = isset($model->$slug)
				? Str::slug($model->$slug)
				: Str::slug($model->$name);
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
		return defined('static::DISPLAY_NAME') ? static::DISPLAY_NAME : 'name';
	}

	/**
	 * Get the name of the slug column.
	 *
	 * @return string
	 */
	public static function getSlugColumn()
	{
		return defined('static::SLUG') ? static::SLUG : 'slug';
	}

}
