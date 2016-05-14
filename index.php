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

/**
* Will be used with sprintf() later so use %% for %
* Used for system errors (entire page is taken up) feel free to change
*/
$sysErrorHtml = <<<EOT
<html><head></head><body style='margin:0;padding:0;'>
	<div style='width: 100%%; height: 100%%;margin: 0;background-color: #F5F5F5;'>
	<br />
		<p style='-webkit-box-shadow: -1px 6px 26px -6px rgba(0,0,0,0.75);
		-moz-box-shadow: -1px 6px 26px -6px rgba(0,0,0,0.75);
		box-shadow: -1px 6px 26px -6px rgba(0,0,0,0.75);
		font-family:Verdana;
		margin: auto;margin-top:10px;font-size: 16px; border-radius: 2.5px; padding: 10px; border: 1px solid lightgray; width: 500px;text-align: center;background-color: white;'>
			<!-- Error Here --> %s <!-- Error Here -->
		</p>
	</div>
	</body></html>
EOT;

//Feel free to remove this version check but do so at your own risk
if (version_compare(phpversion(), '5.4.0', '<')===true) {
    echo sprintf($sysErrorHtml, '<span>PHPScript support PHP 5.4.0 and new only.</span>');
    exit;
}

//Alter this variable depending on your own projects needs
ini_set('memory_limit', '1024M');

//Error reporting

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

//Define any paths and hardcodes
define('PSCRIPT_ROOT', getcwd());
define('PSCRIPT_INIT', true);
define('PSCRIPT_PHP_ENGINE', 'phpengine');
define('PSCRIPT_JS_ENGINE', 'jsengine');
define('PSCRIPT_NS', 'PScript');
//Folder seperator
define('FS', '/');
define('PSCRIPT_PHP_ENGINE_PATH', PSCRIPT_ROOT . FS . PSCRIPT_PHP_ENGINE . FS . PSCRIPT_NS . FS);
define('PSCRIPT_JS_ENGINE_PATH', PSCRIPT_ROOT . FS . PSCRIPT_JS_ENGINE . FS . PSCRIPT_NS . FS);

//Get config
$config = PSCRIPT_ROOT . '/config.php';

if(!file_exists($config)) {
		echo sprintf($sysErrorHtml, '[0001] Config file for PScript cannot be found (config.php)');
		exit;
}

//Used in files to check direct access
$_pScript = true;

require_once($config);

$engineFile = PSCRIPT_PHP_ENGINE_PATH . 'PScript.php';

if(!file_exists($engineFile)) {
		echo sprintf($sysErrorHtml, '[0002] PScript cannot be found');
		exit;
}

require_once($engineFile);

PScript::init();

?>