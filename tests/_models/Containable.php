<?php

namespace test;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Contain\Containable as ContainableTrait;
use Reactor\Files\Contract\Contain\Containable as ContainableContract;

class Containable extends Eloquent implements ContainableContract {

    use ContainableTrait;

    /**
     * @var string
     */
    protected $containerModel = 'test\Container';

}