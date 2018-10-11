<?php

use Reactor\Files\Directory;
use Reactor\Files\Media\Audio;
use Reactor\Files\Media\Image;
use Reactor\Files\Media\Media;

class MediaTest extends TestBase {

    public function setUp()
    {
        parent::setUp();

        Media::flushEventListeners();

        Media::boot();
    }

    protected function getNewMedia($attributes = [])
    {
        return Media::create($attributes);
    }

    protected function getNewDirectory($attributes = [])
    {
        return Directory::create($attributes);
    }

    /** @test */
    function it_returns_and_changes_parent_directory()
    {
        $media = $this->getNewMedia([
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.jpg'
        ]);

        $directory = $this->getNewDirectory(['name' => 'parent']);
        $directory2 = $this->getNewDirectory(['name' => 'parent2']);

        $this->assertNull(
            $media->getParentDirectory()
        );

        $media->moveToDirectory($directory);

        $this->assertEquals(
            $directory,
            $media->getParentDirectory()
        );

        $media->moveToDirectory($directory2);

        $this->assertEquals(
            $directory2,
            $media->getParentDirectory()
        );
    }

    /** @test */
    function it_can_move_to_root()
    {
        $media = $this->getNewMedia([
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.jpg'
        ]);

        $directory = $this->getNewDirectory(['name' => 'parent']);

        $media->moveToDirectory($directory);

        $this->assertEquals(
            $directory,
            $media->getParentDirectory()
        );

        $this->assertFalse(
            $media->isInRoot()
        );

        $media->moveToRoot();

        $this->assertTrue(
            $media->isInRoot()
        );
    }

    /** @test */
    function it_auto_determines_type_on_creation()
    {
        $media = $this->getNewMedia([
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.jpg'
        ]);

        $this->assertEquals(
            $media->getMediaType(),
            'image'
        );
    }

    /** @test */
    function it_auto_determines_type_on_load()
    {
        $directory = $this->getNewDirectory(['name' => 'parent']);

        $image = $this->getNewMedia([
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.jpg'
        ]);

        $document = $this->getNewMedia([
            'extension' => 'txt',
            'mimetype'  => 'text/plain',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.txt'
        ]);

        $audio = $this->getNewMedia([
            'extension' => 'mp4',
            'mimetype'  => 'audio/mp4',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.mp4'
        ]);

        $directory->contain($image);
        $directory->contain($document);

        $i = $directory->getContainedMedia()->find(
            $image->getKey()
        );

        $this->assertInstanceOf(
            'Reactor\Files\Media\Image',
            $i
        );

        $d = $directory->getContainedMedia()->find(
            $document->getKey()
        );

        $this->assertInstanceOf(
            'Reactor\Files\Media\Document',
            $d
        );

        $a = Media::find(
            $audio->getKey()
        );

        $this->assertInstanceOf(
            'Reactor\Files\Media\Audio',
            $a
        );
    }

    /** @test */
    function it_fails_to_load_other_types()
    {
        $media = $this->getNewMedia([
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
            'size'      => 1000,
            'name'      => 'test',
            'path'      => 'root/test.jpg'
        ]);

        $this->assertEquals(
            $media->getKey(),
            Image::find($media->getKey())->getKey()
        );

        $this->assertEquals(
            $media->getKey(),
            Media::find($media->getKey())->getKey()
        );

        $this->assertNull(
            Audio::find($media->getKey())
        );
    }
}