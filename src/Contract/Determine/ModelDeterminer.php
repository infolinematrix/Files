<?php

namespace Reactor\Files\Contract\Determine;


interface ModelDeterminer {

    /**
     * Returns the media type for given mimetype
     *
     * @param string $mimetype
     * @return string
     */
    public function getMediaType($mimetype);

    /**
     * Returns the model class name for given type
     *
     * @param $type
     * @return string
     */
    public function getMediaModelName($type);

    /**
     * Returns the default media model class path
     *
     * @return string
     */
    public function getDefaultMediaModelName();

}