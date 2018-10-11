<?php

namespace Reactor\Files\Substitute;


use Reactor\Files\Contract\Substitute\Substitutable as SubstitutableContract;

trait Substitutes {

    /**
     * Returns the substitutes
     *
     * @return mixed
     */
    public function getSubstitutes()
    {
        return $this->substitutes;
    }

    /**
     * Adds a substitute
     *
     * @param SubstitutableContract $substitute
     */
    public function addSubstitute(SubstitutableContract $substitute)
    {
        $substitute->substituteFor($this);

        $this->reloadSubstitutes();
    }

    /**
     * Removes a substitute
     *
     * @param SubstitutableContract $substitute
     */
    public function removeSubstitute(SubstitutableContract $substitute)
    {
        $substitute->delete();

        $this->reloadSubstitutes();
    }

    /**
     * Reloads substitutes relation
     */
    protected function reloadSubstitutes()
    {
        $this->load('substitutes');
    }

    /**
     * Relation for substitutes
     *
     * @return HasMany
     */
    public function substitutes()
    {
        return $this->hasMany(
            $this->getSubstituteClassName(),
            $this->getGenuineKeyName(),
            $this->getKeyName()
        );
    }

    /**
     * Returns the current class name
     *
     * @return string
     */
    public function getSubstituteClassName()
    {
        // We define the substituteModelName attribute implicitly
        // in order to avoid incompatibility issues with parent class
        return $this->substituteModelName ?: 'Reactor\Files\Substitute\Substitute';
    }

    /**
     * Returns the container key
     *
     * @return string
     */
    public function getGenuineKeyName()
    {
        // We define the genuineKey attribute implicitly
        // in order to avoid incompatibility issues with parent class
        return $this->genuineKey ?: 'media_id';
    }

}