<?php

class ModelDeterminerTest extends TestBase {

    protected function getDeterminer()
    {
        return app()->make('files.model_determiner');
    }

    /** @test */
    function it_gets_media_type()
    {
        $this->assertEquals(
            $this->getDeterminer()->getMediaType('image/jpeg'),
            'image'
        );

        $this->assertEquals(
            $this->getDeterminer()->getMediaType('audio/mp4'),
            'audio'
        );
    }

    /** @test */
    function it_gets_the_media_model_name()
    {
        $this->assertEquals(
            $this->getDeterminer()->getMediaModelName('image'),
            'Reactor\Files\Media\Image'
        );

        $this->assertEquals(
            $this->getDeterminer()->getMediaModelName('video'),
            'Reactor\Files\Media\Video'
        );
    }

    /** @test */
    function it_gets_default_model_name()
    {
        $this->assertEquals(
            $this->getDeterminer()->getDefaultMediaModelName(),
            'Reactor\Files\Media\Media'
        );
    }

}