<?php

namespace test;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Contain\MediaContainer as MediaContainerTrait;
use Reactor\Files\Contract\Contain\MediaContainer as MediaContainerContract;

class MediaContainer extends Eloquent implements MediaContainerContract {

    use MediaContainerTrait;

    /**
     * Returns the container key
     *
     * @return string
     */
    public function getContainerKeyName()
    {
        return 'directory_id';
    }

}