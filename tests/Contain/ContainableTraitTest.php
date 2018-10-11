<?php


use test\Containable;

class ContainableTraitTest extends TestBase {

    protected function getNewContainable()
    {
        return test\Containable::create([]);
    }

    protected function getNewContainer()
    {
        return test\Container::create([]);
    }

    /** @test */
    function it_returns_its_container()
    {
        $containable = $this->getNewContainable();

        $this->assertNull(
            $containable->getContainer()
        );

        $container = $this->getNewContainer();
        $containable->moveToContainer($container);

        $this->assertEquals(
            $containable->getContainer(),
            $container
        );

        $this->assertInstanceOf(
            $containable->getContainerClassName(),
            $container
        );
    }

    /** @test */
    function it_changes_its_container()
    {
        $container1 = $this->getNewContainer();
        $container2 = $this->getNewContainer();

        $containable = $this->getNewContainable();

        $containable->moveToContainer($container1);

        $this->assertEquals(
            $container1,
            $containable->getContainer()
        );

        $containable->moveToContainer($container2);

        $this->assertEquals(
            $container2,
            $containable->getContainer()
        );
    }

    /** @test */
    function it_moves_self_to_root()
    {
        $container = $this->getNewContainer();

        $containable = $this->getNewContainable();

        $containable->moveToContainer($container);

        $this->assertEquals(
            $container,
            $containable->getContainer()
        );

        $this->assertFalse(
            $containable->isInRoot()
        );

        $containable->moveToRoot();

        $this->assertNull(
            $containable->getContainer()
        );

        $this->assertTrue(
            $containable->isInRoot()
        );
    }

    /** @test */
    function it_returns_the_container_key_name()
    {
        $containable = $this->getNewContainable();

        $this->assertEquals(
            'container_id', // Default for trait and unchanged in test\Containable model
            $containable->getContainerKeyName()
        );
    }

    /** @test */
    function it_returns_the_container_class_name()
    {
        $containable = $this->getNewContainable();

        $this->assertEquals(
            'test\Container', // This has been changed in test\Containable model
            $containable->getContainerClassName()
        );
    }

    /** @test */
    function it_can_use_root_scope()
    {
        $inRoot = $this->getNewContainable();
        $contained = $this->getNewContainable();

        $container = $this->getNewContainer();
        $contained->moveToContainer($container);

        $containables = Containable::inRoot()->get();

        $this->assertNull(
            $containables->find($contained->getKey())
        );

        $this->assertNotNull(
            $containables->find($inRoot->getKey())
        );
    }

    /** @test */
    function it_returns_container_relation()
    {
        $containable = $this->getNewContainable();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $containable->container()
        );
    }

}