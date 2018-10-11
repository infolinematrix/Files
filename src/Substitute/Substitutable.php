<?php

namespace Reactor\Files\Substitute;


use Reactor\Files\Contract\Substitute\Substitutes as SubstitutesContract;

trait Substitutable {

    /**
     * Getter for genuine
     *
     * @return mixed
     */
    public function getGenuine()
    {
        return $this->genuine;
    }

    /**
     * Substitutes self for genuine
     *
     * @param SubstitutesContract $genuine
     * @return mixed
     */
    public function substituteFor(SubstitutesContract $genuine)
    {
        $this->genuine()->associate($genuine);

        $this->save();
    }

    /**
     * Relation for genuine
     *
     * @return BelongsTo
     */
    public function genuine()
    {
        return $this->belongsTo(
            $this->getMediaClassName(),
            $this->getGenuineKey(),
            $this->getKeyName()
        );
    }

    /**
     * Returns the default media class name
     *
     * @return string
     */
    public function getGenuineKey()
    {
        return $this->genuineKey ?: 'media_id';
    }

    /**
     * Returns the media class name
     *
     * @return string
     */
    public function getMediaClassName()
    {
        return $this->mediaModelName
            ?: app()['files.model_determiner']->getDefaultMediaModelName();
    }

}