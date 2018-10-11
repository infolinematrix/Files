<?php

use Reactor\Files\Substitute\Substitutable;
use Mockery as m;
use test\Substituter;

class SubstitutesTest extends TestBase {

    protected function getNewSubstitutable($attributes = [])
    {
        return Substitutable::forceCreate($attributes);
    }

    protected function getNewSubstituter($attributes = [])
    {
        return Substituter::forceCreate($attributes);
    }

    /** @test */
    function it_returns_substitutes()
    {
        $substituter = $this->getNewSubstituter();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $substituter->getSubstitutes()
        );
    }

    /** @test */
    function it_adds_substitute()
    {
        $substituter = $this->getNewSubstituter();

        $substitutable = m::mock('Reactor\Files\Contract\Substitute\Substitutable')
            ->shouldReceive('substituteFor')
            ->with($substituter)
            ->andThrow('Exception', 'Success')
            ->mock();

        try
        {
            $substituter->addSubstitute($substitutable);
        } catch (Exception $e)
        {
            if ($e->getMessage() === 'Success')
            {
                return;
            }
        }

        $this->fail('substitudeFor() call was not received; test fails.');
    }

    /** @test */
    function it_removes_a_substitute()
    {
        $substituter = $this->getNewSubstituter();

        $substitutable = m::mock('Reactor\Files\Contract\Substitute\Substitutable')
            ->shouldReceive('delete')
            ->withNoArgs()
            ->andThrow('Exception', 'Success')
            ->mock();

        try
        {
            $substituter->removeSubstitute($substitutable);
        } catch (Exception $e)
        {
            if ($e->getMessage() === 'Success')
            {
                return;
            }
        }

        $this->fail('delete() call was not received; test fails.');
    }

    /** @test */
    function it_returns_the_substitutes_relation()
    {
        $substituter = $this->getNewSubstituter();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $substituter->substitutes()
        );
    }

    /** @test */
    function it_returns_the_media_class_name()
    {
        $substituter = $this->getNewSubstituter();

        $this->assertEquals(
            'test\Substitutable', // This has been changed in test\Substituter model
            $substituter->getSubstituteClassName()
        );
    }

    /** @test */
    function it_returns_the_genuine_key_name()
    {
        $substituter = $this->getNewSubstituter();

        $this->assertEquals(
            'media_id', // Default for trait and unchanged in test\Containable model
            $substituter->getGenuineKeyName()
        );
    }
}