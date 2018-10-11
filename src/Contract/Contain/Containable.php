<?php

namespace Reactor\Files\Contract\Contain;


interface Containable {

    /**
     * Getter for container
     *
     * @return mixed
     */
    public function getContainer();

    /**
     * Sets the container
     *
     * @param mixed $container
     */
    public function moveToContainer($container);

    /**
     * Moves containable to root
     */
    public function moveToRoot();

    /**
     * Determines if containable is in root
     *
     * @return bool
     */
    public function isInRoot();

}