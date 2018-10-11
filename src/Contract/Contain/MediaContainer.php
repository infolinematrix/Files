<?php

namespace Reactor\Files\Contract\Contain;


interface MediaContainer {

    /**
     * Returns the children media
     *
     * @return mixed
     */
    public function getContainedMedia();

    /**
     * Contains a containable
     *
     * @param Containable $containable
     * @return Containable
     */
    public function contain(Containable $containable);

    /**
     * Returns the current class name
     *
     * @return string
     */
    public function getMediaClassName();

    /**
     * Returns the container key
     *
     * @return string
     */
    public function getContainerKeyName();

}