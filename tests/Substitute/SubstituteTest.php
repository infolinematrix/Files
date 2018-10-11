<?php


use Reactor\Files\Media\Audio;
use Reactor\Files\Substitute\Substitute;

class SubstituteTest extends TestBase {

    protected function getNewMedia()
    {
        return Audio::create([
            'name'      => '',
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000
        ]);
    }

    protected function getNewSubstitute($attributes = [])
    {
        return Substitute::forceCreate($attributes);
    }

    /** @test */
    function it_gets_genuine()
    {
        $media = $this->getNewMedia();

        $substitute = $this->getNewSubstitute([
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000,
            'media_id'  => $media->getKey()
        ]);

        $this->assertEquals(
            $substitute->getGenuine()->getKey(),
            $media->getKey()
        );

    }

    /** @test */
    function it_sets_self_as_substitute()
    {
        $media = $this->getNewMedia();

        $substitute = $this->getNewSubstitute([
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000
        ]);

        $this->assertNull(
            $substitute->getGenuine()
        );

        $substitute->substituteFor($media);

        $this->assertEquals(
            $substitute->getGenuine()->getKey(),
            $media->getKey()
        );
    }

    /** @test */
    function it_deletes_self()
    {
        $substitute = $this->getNewSubstitute([
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000
        ]);

        $this->assertNotNull(
            Substitute::find($substitute->getKey())
        );

        $substitute->delete();

        $this->assertNull(
            Substitute::find($substitute->getKey())
        );
    }

    /** @test */
    function it_gets_returned_as_substitute()
    {
        $media = $this->getNewMedia();

        $substitute = $this->getNewSubstitute([
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000
        ]);

        $substitute->substituteFor($media);

        $this->assertTrue(
            $media->getSubstitutes()->contains(
                $substitute->getKey()
            )
        );
    }

    /** @test */
    function it_gets_added_as_substitute()
    {
        $media = $this->getNewMedia();

        $substitute = $this->getNewSubstitute([
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000
        ]);

        $media->addSubstitute($substitute);

        $this->assertTrue(
            $media->getSubstitutes()->contains(
                $substitute->getKey()
            )
        );
    }

    /** @test */
    function it_gets_removed_as_substitutes()
    {
        $media = $this->getNewMedia();

        $substitute = $this->getNewSubstitute([
            'path'      => '',
            'extension' => 'ext',
            'mimetype'  => 'audio/ogg',
            'size'      => 1000
        ]);

        $media->addSubstitute($substitute);

        $this->assertTrue(
            $media->getSubstitutes()->contains(
                $substitute->getKey()
            )
        );

        $media->removeSubstitute($substitute);

        $this->assertFalse(
            $media->getSubstitutes()->contains(
                $substitute->getKey()
            )
        );
    }

}