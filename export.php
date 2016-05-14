<?php

function rcopy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                rcopy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

function delTree($dir) { 
   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  }

$_pScript = true;

require("config.php");

function out($m) {
	print $m."\n";
}

out("Exporting...");


copy("index.html", "myapp-offline/index.html");

rcopy("myapp/", "myapp-offline/myapp/");
rcopy("jsengine/", "myapp-offline/jsengine/");

delTree("myapp-offline/myapp/blocks");
delTree("myapp-offline/myapp/pages");
delTree("myapp-offline/myapp/php");

?>