<?php

use test\Substitutable;
use test\Substituter;

class SubstitutableTest extends TestBase {

    protected function getNewSubstitutable($attributes = [])
    {
        return Substitutable::forceCreate($attributes);
    }

    protected function getNewSubstituter($attributes = [])
    {
        return Substituter::forceCreate($attributes);
    }

    /** @test */
    function it_returns_its_genuine()
    {
        $substitutable = $this->getNewSubstitutable();

        $this->assertNull(
            $substitutable->getGenuine()
        );

        $substitutes = $this->getNewSubstituter();

        $substitutable = $this->getNewSubstitutable([
            'media_id' => $substitutes->getKey()
        ]);

        $this->assertEquals(
            $substitutable->getGenuine()->getKey(),
            $substitutes->getKey()
        );
    }

    /** @test */
    function it_sets_self_as_substitute()
    {
        $substitutable = $this->getNewSubstitutable();

        $this->assertNull(
            $substitutable->getGenuine()
        );

        $substitutes = $this->getNewSubstituter();

        $substitutable->substituteFor($substitutes);

        $this->assertEquals(
            $substitutable->getGenuine(),
            $substitutes
        );

        $substitutes2 = $this->getNewSubstituter();

        $substitutable->substituteFor($substitutes2);

        $this->assertEquals(
            $substitutable->getGenuine(),
            $substitutes2
        );
    }

    /** @test */
    function it_deletes_self()
    {
        $substitutable = $this->getNewSubstitutable();

        $this->assertNotNull(
            Substitutable::find($substitutable->getKey())
        );

        $substitutable->delete();

        $this->assertNull(
            Substitutable::find($substitutable->getKey())
        );
    }

    /** @test */
    function it_returns_genuine_relation()
    {
        $substitutable = $this->getNewSubstitutable();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $substitutable->genuine()
        );
    }

    /** @test */
    function it_returns_the_genuine_key_name()
    {
        $substitutable = $this->getNewSubstitutable();

        $this->assertEquals(
            'media_id', // Default for trait and unchanged in test\Containable model
            $substitutable->getGenuineKey()
        );
    }

    /** @test */
    function it_returns_the_media_class_name()
    {
        $substitutable = $this->getNewSubstitutable();

        $this->assertEquals(
            'test\Substituter', // This has been changed in test\Substitutable model
            $substitutable->getMediaClassName()
        );
    }

}