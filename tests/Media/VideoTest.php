<?php

use Reactor\Files\Media\Video;
use Reactor\Files\Substitute\Substitute;

class VideoTest extends TestBase {

    /** @test */
    function it_is_initializable()
    {
        $this->assertInstanceOf(
            'Reactor\Files\Media\Video',
            new Reactor\Files\Media\Video()
        );
    }

    /** @test */
    function it_can_substitute_media()
    {
        $substitute = Substitute::create([
            'path' => '',
            'extension' => 'ext',
            'mimetype' => 'video/ogg',
            'size' => 1000
        ]);

        $video = Video::create([
            'name' => '',
            'path' => '',
            'extension' => 'ext',
            'mimetype' => 'video/ogg',
            'size' => 1000
        ]);

        $video->addSubstitute($substitute);

        $this->assertNotNull(
            $video->getSubstitutes()->find(
                $substitute->getKey()
            )
        );
    }

}