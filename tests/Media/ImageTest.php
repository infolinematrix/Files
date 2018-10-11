<?php

class ImageTest extends TestBase {

    /** @test */
    function it_is_initializable()
    {
        $this->assertInstanceOf(
            'Reactor\Files\Media\Image',
            new Reactor\Files\Media\Image()
        );
    }

}