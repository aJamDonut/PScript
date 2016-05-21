<?php 
function __autoload($class_name) 
{
    $filename = $class_name.'.php';

    $file = 'phpengine/PScript/'.$filename;

    if ( ! file_exists($file))
    {
        return FALSE;
    }
    include $file;
}