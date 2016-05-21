<?php 
function __autoload($class_name) 
{
    $filename = $class_name.'.php';

    $file = getcwd().'/phpengine/PScript/'.$filename;

    if ( ! file_exists($file))
    {
        return FALSE;
    }
    require_once $file;
}