<?php

namespace Reactor\Files\Media;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Contain\Containable;
use Reactor\Files\Contract\Contain\Containable as ContainableContract;
use Reactor\Files\Determine\AutoDeterminesType;

class Media extends Eloquent implements ContainableContract {

    use Containable, AutoDeterminesType;

    /**
     * @var string
     */
    protected $containerKey = 'directory_id';

    /**
     * @var string
     */
    protected $table = 'media';

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'name', 'path', 'metadata'];

    /**
     * Syntactic sugar for moveToContainer
     *
     * @param mixed $container
     */
    public function moveToDirectory($container)
    {
        return $this->moveToContainer($container);
    }

    /**
     * Syntactic sugar for getContainer
     *
     * @return mixed
     */
    public function getParentDirectory()
    {
        return $this->getContainer();
    }

}