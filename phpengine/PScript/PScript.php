<?php
/** 
* PScript Main Index
*
* PScript (PHP + Javascript) is a light weight novice level PHP framework
* for building rich interactive websites in PHP and Javascript
* @author 				Adam Dougherty 
* @version 			0.1
* @package 			PScript
* @copyright  Copyright (c) 2026 Adam Dougherty
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

final class PScript {
	private $theme = "default";
	
	//Start PScript
	public static function init() {
		
			//Handle non-php files
			
			//var_dump($_SERVER['REQUEST_URI']);
			
			$URI = explode("/",$_SERVER['REQUEST_URI']);
			
		if(strpos($_SERVER['REQUEST_URI'], ".js") || strpos($_SERVER['REQUEST_URI'], ".css")) {
			header('Content-Type: text/css');
			echo file_get_contents(PSCRIPT_ROOT . $_SERVER['REQUEST_URI']);
			exit;
		}
		
		if(strpos($_SERVER['REQUEST_URI'], ".html")) {
			echo file_get_contents(PSCRIPT_ROOT . $_SERVER['REQUEST_URI']);
			exit;
		}
		

		self::loadClass('Blocks');
		
		$PScript = new PScript();
		$MyPhp = $PScript;
		$Blocks = new PScript_Blocks();
		
		
		if($URI[1]!="in") {
			//Default themes required for PHP Engine
			self::loadClass('Theme');
			
					
			//Default JS for PScript
			$defaultJs = array();
			//Namespace = Filename
			$defaultJs['jQuery'] = "jquery.js";
			$defaultJs['PScript'] = "PScript.js";
			$PScript_Theme = new PScript_Theme();
			
			$PScript_Theme->setTheme($PScript->theme);
			foreach($defaultJs as $namespace=>$js) {
				$PScript_Theme->addToHead("<script type='text/javascript' src='" . PSCRIPT_JS_ENGINE . FS. $namespace . FS . $js . "'></script>");
			}
			ob_start();
			$file = "index";
			require("myapp/pages/{$file}.phtml");
			$output = ob_get_contents();
			ob_end_clean();
			//This is where we'll output all the generated html
			ob_start();
			$PScript_Theme->output($output);
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
			file_put_contents("{$file}.html", $output);
			} elseif ($URI[1]=="in") {
				
				ob_start();
				$file = $URI[2];
				require("myapp/blocks/{$URI[2]}.phtml");
				$output = ob_get_contents();
				ob_end_clean();	
				echo $output;
			}
			file_put_contents("myapp/offline/{$file}.html", $output);
	}

	public function myPhp($name) {
		require_once("myapp/php/{$name}.php");
		return New $name();
	}
	
	private static function loadClass($class) {
		require_once(PSCRIPT_PHP_ENGINE . FS . PSCRIPT_NS. FS . PSCRIPT_NS . '_' . $class . ".php");
	}
	
}

?>