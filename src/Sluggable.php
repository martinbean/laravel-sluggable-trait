<?php

namespace mvnrsa\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Boot the sluggable trait for a model.
     *
     * @return void
     */
    public static function bootSluggable()
    {
        static::saving(function (Model $model) {
            if (empty($model->getSlug())) {
                $model->setSlug(Str::slug($model->getSluggableString(),$model->getSlugCharacter()));
            }
        });
    }

    /**
     * The name of the column to use for slugs.
     *
     * @return string
     */
    public function getSlugColumnName()
    {
        return 'slug';
    }

    /**
     * Get the current slug value.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->getAttribute($this->getSlugColumnName());
    }

    /**
     * Set the slug to the given value.
     *
     * @param  string  $value
     * @return $this
     */
    public function setSlug($value)
    {
        $this->setAttribute($this->getSlugColumnName(), $value);

        return $this;
    }

    /**
     * Get the string to create a slug from.
     *
     * @return string
     */
    public function getSluggableString()
    {
        return $this->getAttribute('name');
    }

    /**
     * Allows overriding the character used in slugs.
     *
     * @return string
     */
    public function getSlugCharacter()
    {
        return '_';
    }
}
