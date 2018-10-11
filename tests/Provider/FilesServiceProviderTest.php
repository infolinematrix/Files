<?php

class FilesServiceProviderTest extends TestBase {

    /** @test */
    function it_registers_model_determiner()
    {
        $this->assertInstanceOf(
            'Reactor\Files\Determine\ModelDeterminer',
            app()->make('files.model_determiner')
        );
    }

}