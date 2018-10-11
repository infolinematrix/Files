<?php

namespace test;


use Illuminate\Database\Eloquent\Model as Eloquent;
use Reactor\Files\Determine\AutoDeterminesType;

class Determinable extends Eloquent {

    use AutoDeterminesType;

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['filetype', 'mimetype'];

    /**
     * @var string
     */
    protected $typeKeyName = 'filetype';

}