<?php

class PScript_ThemeTest extends PHPUnit_Framework_TestCase
{
					/**
				 * Call protected/private method of a class.
				 *
				 * @param object &$object    Instantiated object that we will run method on.
				 * @param string $methodName Method name to call
				 * @param array  $parameters Array of parameters to pass into method.
				 *
				 * @return mixed Method return.
				 */
				public function invokeMethod(&$object, $methodName, array $parameters = array())
				{
				    $reflection = new \ReflectionClass(get_class($object));
				    $method = $reflection->getMethod($methodName);
				    $method->setAccessible(true);
				
				    return $method->invokeArgs($object, $parameters);
				}
				
				public function testGetBlock() {
					$Blocks = new PScript_Blocks();
					$Blocks->get('test');
					$this->assertEquals(1, 1);
				}
				
				public function testGetPlugin() {
					$Blocks = new PScript_Blocks();
					$Blocks->plugin('utilities', 'test');
					$this->assertEquals(1, 1);
				}
}
