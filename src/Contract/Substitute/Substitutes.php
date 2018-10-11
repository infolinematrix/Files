<?php

namespace Reactor\Files\Contract\Substitute;


interface Substitutes {

    /**
     * Returns the substitutes
     *
     * @return mixed
     */
    public function getSubstitutes();

    /**
     * Adds a substitute
     *
     * @param Substitutable $substitute
     */
    public function addSubstitute(Substitutable $substitute);

    /**
     * Removes a substitute
     *
     * @param Substitutable $substitute
     */
    public function removeSubstitute(Substitutable $substitute);

}