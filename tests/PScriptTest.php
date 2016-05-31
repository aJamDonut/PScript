<?php

class PScriptTest extends PHPUnit_Framework_TestCase
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
				
				public function testCanLoadPScript() {
								$PScript = new PScript();
								$this->assertInstanceOf('PScript', $PScript);
								//Use this later on in tests by using @depends
								return  $PScript;
				}
				
				/**
				 * @depends testCanLoadPScript
				 */
				public function testTestCanUsePScript($PScript) {
								$this->assertInstanceOf('PScript', $PScript);							
				}
			
				public function testHooksLoaded() {
							global $hooks;
							$this->assertInstanceOf('Hooks', $hooks);
				}

				public function testCanAddHook() {
							global $hooks;
							$hooks->add_action('test_hook', function(){ global $e; $e=1; });	
							$hooks->do_action('test_hook');
							global $e;
							$this->assertEquals($e, 1);	
				}
				
				public function testCanSetHead() {
							
							$head = PScript::setHead('Header');
							$this->assertEquals($head, 1);
				}
				
				/**
				 * @depends testCanLoadPScript
				 */
				public function testCanLoadClasses($PScript) {
						$this->invokeMethod($PScript, 'loadClass', array('Theme'));
						$Theme = new PScript_Theme();
						$this->assertInstanceOf('PScript_Theme', $Theme);
				}
				/**
				 * @depends testCanLoadPScript
				 */
				public function testCanLoadPlugins($PScript) {
						$Util = $PScript->plugin('utilities');
						$this->assertInstanceOf('utilities', $Util); 
				}
				
				/**
				 * @depends testCanLoadPScript
				 */
				public function testCanLoadMyApp($PScript) {
						$Main = $PScript->myPhp('main');
						$this->assertInstanceOf('main', $Main); 
				}
				
}
