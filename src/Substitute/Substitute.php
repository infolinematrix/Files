<?php

namespace Reactor\Files\Substitute;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Contract\Substitute\Substitutable as SubstitutableContract;

class Substitute extends Eloquent implements SubstitutableContract {

    use Substitutable;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'path'];

}