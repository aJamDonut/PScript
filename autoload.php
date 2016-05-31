<?php 
function __autoload($class_name) 
{
    $filename = $class_name.'.php';

    $file = 'phpengine/PScript/'.$filename;
    if ( ! file_exists($file))
    {
        return FALSE;
    }
    require_once $file;
}
spl_autoload_register('__autoload');
require_once('shortnames.php');
require_once('vendor/autoload.php');
