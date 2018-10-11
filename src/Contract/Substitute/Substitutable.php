<?php

namespace Reactor\Files\Contract\Substitute;


interface Substitutable {

    /**
     * Getter for genuine
     *
     * @return mixed
     */
    public function getGenuine();

    /**
     * Substitutes self for genuine
     *
     * @param Substitutes $genuine
     * @return mixed
     */
    public function substituteFor(Substitutes $genuine);

    /**
     * Removes a substitutable
     *
     * @return mixed
     */
    public function delete();

}