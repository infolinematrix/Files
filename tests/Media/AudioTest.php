<?php

use Reactor\Files\Media\Audio;
use Reactor\Files\Substitute\Substitute;

class AudioTest extends TestBase {

    /** @test */
    function it_is_initializable()
    {
        $this->assertInstanceOf(
            'Reactor\Files\Media\Audio',
            new Reactor\Files\Media\Audio()
        );
    }

    /** @test */
    function it_can_substitute_media()
    {
        $substitute = Substitute::create([
            'path' => '',
            'extension' => 'ext',
            'mimetype' => 'audio/ogg',
            'size' => 1000
        ]);

        $audio = Audio::create([
            'name' => '',
            'path' => '',
            'extension' => 'ext',
            'mimetype' => 'audio/ogg',
            'size' => 1000
        ]);

        $audio->addSubstitute($substitute);

        $this->assertNotNull(
            $audio->getSubstitutes()->find(
                $substitute->getKey()
            )
        );
    }

}