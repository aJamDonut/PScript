<?php
class PScriptTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testTestLoads()
    {
        
        $this->assertEquals(true, true);
    }

				public function testCanLoadPScript() {
								
								$PScript =  new PScript();
								$this->assertInstanceOf('PScript', $PScript);
				}

    // ...
}
