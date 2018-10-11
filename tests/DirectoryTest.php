<?php

use Reactor\Files\Directory;
use Reactor\Files\Media\Image;
use Reactor\Files\Media\Media;

class DirectoryTest extends TestBase {

    protected function getNewDirectory($attributes = [])
    {
        return Directory::create($attributes);
    }

    /** @test */
    function it_gets_subdirectories()
    {
        $directory = $this->getNewDirectory(['name' => 'test']);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $directory->getSubdirectories()
        );
    }

    /** @test */
    function it_can_have_subdirectories()
    {
        $parent = $this->getNewDirectory(['name' => 'parent']);
        $child = $this->getNewDirectory(['name' => 'child']);

        $parent->contain($child);

        $this->assertNotNull(
            $parent->getSubdirectories()->find(
                $child->getKey()
            )
        );
    }

    /** @test */
    function it_returns_the_parent_directory()
    {
        $parent = $this->getNewDirectory(['name' => 'parent']);
        $child = $this->getNewDirectory(['name' => 'child']);

        $this->assertNull(
            $child->getParentDirectory()
        );

        $parent->contain($child);

        $this->assertEquals(
            $child->getParentDirectory(),
            $parent
        );
    }

    /** @test */
    function it_changes_parent_directory()
    {
        $parent1 = $this->getNewDirectory(['name' => 'p1']);
        $parent2 = $this->getNewDirectory(['name' => 'p2']);
        $child = $this->getNewDirectory(['name' => 'child']);

        $this->assertNull(
            $child->getParentDirectory()
        );

        $child->moveToDirectory($parent1);

        $this->assertEquals(
            $parent1,
            $child->getParentDirectory()
        );

        $child->moveToDirectory($parent2);

        $this->assertEquals(
            $parent2,
            $child->getParentDirectory()
        );
    }

    /** @test */
    function it_can_move_to_root()
    {
        $parent = $this->getNewDirectory(['name' => 'parent']);
        $child = $this->getNewDirectory(['name' => 'child']);

        $child->moveToDirectory($parent);

        $this->assertEquals(
            $parent,
            $child->getParentDirectory()
        );

        $this->assertFalse(
            $child->isInRoot()
        );

        $child->moveToRoot();

        $this->assertTrue(
            $child->isInRoot()
        );
    }

    /** @test */
    function it_returns_child_media()
    {
        $directory = $this->getNewDirectory(['name' => 'test']);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $directory->getContainedMedia()
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

        $directory = Directory::create(['name' => 'parent']);

        $directory->contain($image);
        $directory->contain($media);

        $this->assertNotNull(
            $directory->getContainedMedia()->find(
                $image->getKey()
            )
        );

        $this->assertNotNull(
            $directory->getContainedMedia()->find(
                $media->getKey()
            )
        );
    }

    /** @test */
    function it_returns_subdirectories_relation()
    {
        $directory = Directory::create(['name' => 'parent']);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $directory->subdirectories()
        );
    }

}