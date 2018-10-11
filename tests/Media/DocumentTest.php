<?php

class DocumentTest extends TestBase {

    /** @test */
    function it_is_initializable()
    {
        $this->assertInstanceOf(
            'Reactor\Files\Media\Document',
            new Reactor\Files\Media\Document()
        );
    }

}