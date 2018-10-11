<?php

use test\Determinable;

class AutoDeterminesTypeTraitTest extends TestBase {

    public function setUp()
    {
        parent::setUp();

        Determinable::flushEventListeners();

        Determinable::boot();
    }

    protected function getNewDeterminable($attributes = [
        'filetype' => null,
        'mimetype' => 'test/test'
    ])
    {
        return Determinable::create($attributes);
    }

    /** @test */
    function it_sets_the_media_type()
    {
        $determinable = new Determinable([
            'mimetype' => 'image/jpeg'
        ]);

        $this->assertNull(
            $determinable->getMediaType()
        );

        $determinable->setMediaType();

        $this->assertEquals(
            $determinable->getMediaType(),
            'image'
        );
    }

    /** @test */
    function it_gets_media_type()
    {
        $determinable = $this->getNewDeterminable([
            'filetype' => 'image',
            'mimetype' => 'image/jpeg'
        ]);

        $this->assertEquals(
            $determinable->getMediaType(),
            'image'
        );
    }

    /** @test */
    function it_sets_the_media_type_on_creation()
    {
        $determinable = $this->getNewDeterminable([
            'mimetype' => 'image/jpeg'
        ]);

        $this->assertEquals(
            $determinable->getMediaType(),
            'image'
        );
    }

    /** @test */
    function it_returns_model_instance_by_type()
    {
        $determinable = $this->getNewDeterminable([
            'filetype' => 'image',
            'mimetype' => 'image/jpeg'
        ]);

        $this->assertInstanceOf(
            'Reactor\Files\Media\Image',
            Determinable::find($determinable->getKey())
        );

        $determinable = $this->getNewDeterminable([
            'filetype' => 'audio',
            'mimetype' => 'audio/mp4'
        ]);

        $this->assertInstanceOf(
            'Reactor\Files\Media\Audio',
            Determinable::find($determinable->getKey())
        );
    }

    /** @test */
    function it_fallsback_to_default_if_type_is_not_matched()
    {
        $determinable = $this->getNewDeterminable()
            ->newFromBuilder([
                'filetype' => null,
                'mimetype' => 'nosuch/type'
            ]);

        $this->assertInstanceOf(
            'Reactor\Files\Media\Media',
            $determinable
        );
    }

    /** @test */
    function it_creates_with_type_from_builder()
    {
        $determinable = $this->getNewDeterminable();

        $determinable = $determinable->newFromBuilder([
            'filetype' => 'image',
            'mimetype' => 'image/jpeg'
        ]);

        $this->assertInstanceOf(
            'Reactor\Files\Media\Image',
            $determinable
        );
    }

}