<?php

namespace Reactor\Files\Determine;


trait AutoDeterminesType {

    /**
     * Boot trait
     */
    public static function bootAutoDeterminesType()
    {
        static::creating(function ($model)
        {
            $model->setMediaType();
        });

        static::addGlobalScope(new TypeScope);
    }

    /**
     * Sets the media type
     */
    public function setMediaType()
    {
        $this->setAttribute(
            $this->getTypeKeyName(),
            $this->determineMediaType()
        );
    }

    /**
     * Returns the media type
     *
     * @return string
     */
    public function getMediaType()
    {
        return $this->getAttribute(
            $this->getTypeKeyName()
        );
    }

    /**
     * Determines the media type
     *
     * @return string
     */
    protected function determineMediaType()
    {
        return is_null($this->getTypeKey()) ?
            $this->getModelDeterminer()->getMediaType(
                $this->getAttribute(
                    $this->getMimeKeyName()
                )
            ) :
            $this->getTypeKey();
    }

    /**
     * Returns the determiner
     *
     * @return ModelDeterminer
     */
    protected function getModelDeterminer()
    {
        return app()['files.model_determiner'];
    }

    /**
     * Getter for mime key name
     *
     * @return string
     */
    public function getMimeKeyName()
    {
        return $this->mimeKeyName ?: 'mimetype';
    }

    /**
     * Getter for type key
     *
     * @return string
     */
    public function getTypeKey()
    {
        return $this->mediaType ?: null;
    }

    /**
     * Getter for type key name
     *
     * @return string
     */
    public function getTypeKeyName()
    {
        return $this->typeKeyName ?: 'type';
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array $attributes
     * @param  string|null $connection
     * @return static
     */
    public function newFromBuilder($attributes = array(), $connection = null)
    {
        // We change the creation behavior here by replacing the newInstance call.
        // Instead we create the model directly here. This is to enable
        // single table inheritance.
        $modelName = $this->determineModelName((array)$attributes);

        // This part handles what essentially happens in the newInstance call.
        $model = new $modelName([]);
        $model->exists = true;

        // Rest is the same
        $model->setRawAttributes((array)$attributes, true);

        $model->setConnection($connection ?: $this->connection);

        return $model;
    }

    /**
     * Determines the model name by type
     *
     * @param array $attributes
     * @return string
     */
    protected function determineModelName(array $attributes)
    {
        $keyName = $this->getTypeKeyName();

        return isset($attributes[$keyName]) ?
            $this->getModelDeterminer()->getMediaModelName($attributes[$keyName]) :
            $this->getModelDeterminer()->getDefaultMediaModelName();
    }

}