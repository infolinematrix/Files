<?php

namespace test;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Contract\Substitute\Substitutes as SubstitutesContract;
use Reactor\Files\Substitute\Substitutes as SubstitutesTrait;

class Substituter extends Eloquent implements SubstitutesContract {

    use SubstitutesTrait;

    protected $substituteModelName = 'test\Substitutable';

}