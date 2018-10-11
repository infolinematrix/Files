<?php

namespace Reactor\Files\Media;


use Reactor\Files\Contract\Substitute\Substitutes as SubstitutesContract;
use Reactor\Files\Substitute\Substitutes;

class Audio extends Media implements SubstitutesContract {

    use Substitutes;

    /**
     * @var string
     */
    protected $mediaType = 'audio';

}