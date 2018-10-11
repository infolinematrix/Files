<?php

use Reactor\Files\Media\Image;
use Reactor\Files\Media\Media;
use test\MediaContainer;

class MediaContainerTest extends TestBase {

    protected function getNewMediaContainer()
    {
        return MediaContainer::create([]);
    }

    /** @test */
    function it_returns_child_media()
    {
        $mediaContainer = $this->getNewMediaContainer();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $mediaContainer->getContainedMedia()
        );
    }

    /** @test */
    function it_adds_child_media()
    {
        $image = Image::create([
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.jpg'
        ]);

        $media = Media::create([
            'extension' => 'tst',
            'mimetype'  => 'test/testy',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.tst'
        ]);

        $mediaContainer = $this->getNewMediaContainer();

        $mediaContainer->contain($image);
        $mediaContainer->contain($media);

        $this->assertNotNull(
            $mediaContainer->getContainedMedia()->find(
                $image->getKey()
            )
        );

        $this->assertNotNull(
            $mediaContainer->getContainedMedia()->find(
                $media->getKey()
            )
        );
    }

    /** @test */
    function it_returns_contained_media_relation()
    {
        $container = $this->getNewMediaContainer();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $container->containedMedia()
        );
    }

    /** @test */
    function it_returns_media_class_name()
    {
        $container = $this->getNewMediaContainer();

        $this->assertEquals(
            'Reactor\Files\Media\Media', // Default for trait and unchanged in test\MediaContainer model
            $container->getMediaClassName()
        );
    }

}