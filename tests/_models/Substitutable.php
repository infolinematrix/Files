<?php

namespace test;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Contract\Substitute\Substitutable as SubstitutableContract;
use Reactor\Files\Substitute\Substitutable as SubstitutableTrait;

class Substitutable extends Eloquent implements SubstitutableContract {

    use SubstitutableTrait;

    protected $mediaModelName = 'test\Substituter';

}