<?php 
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
