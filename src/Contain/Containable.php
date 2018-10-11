<?php

namespace Reactor\Files\Contain;


trait Containable {

    /**
     * Getter for container
     *
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Sets the container
     *
     * @param mixed $container
     */
    public function moveToContainer($container)
    {
        $this->container()->associate($container);

        $this->save();
    }

    /**
     * Moves containable to root
     */
    public function moveToRoot()
    {
        $this->container()->dissociate();

        $this->save();
    }

    /**
     * Determines if containable is in root
     *
     * @return bool
     */
    public function isInRoot()
    {
        return is_null(
            $this->getAttribute(
                $this->getContainerKeyName()
            )
        );
    }

    /**
     * Returns the container key
     *
     * @return string
     */
    public function getContainerKeyName()
    {
        // We define the containerKey attribute implicitly
        // in order to avoid incompatibility issues with parent class
        return $this->containerKey ?: 'container_id';
    }

    /**
     * Returns the container class name
     *
     * @return string
     */
    public function getContainerClassName()
    {
        // We define the containerModel attribute implicitly
        // in order to avoid incompatibility issues with parent class
        return $this->containerModel ?: 'Reactor\Files\Directory';
    }

    /**
     * Root scope
     *
     * @param Builder $query
     * @return Builder $query
     */
    public function scopeInRoot($query)
    {
        return $query->where(
            $this->getContainerKeyName(),
            null
        );
    }

    /**
     * Relation for parent directory
     *
     * @return BelongsTo
     */
    public function container()
    {
        return $this->belongsTo(
            $this->getContainerClassName(),
            $this->getContainerKeyName(),
            $this->getKeyName()
        );
    }

}