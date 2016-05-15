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


$jsConfig = <<<EOT
			
				remoteURI : '{$_CONFIG['remote_url']}',
    mode: 'offline',
    outputFolder: 'myapp/offline',
    ext: '.html',
    delay:1000, /* Delay for checking how it will work in slow environments */
    domain : "{$_CONFIG['live_url']}"
			
EOT;
			
			$js = file_get_contents("myapp-offline/jsengine/PScript/PScript.js");
			
			$js = str_replace("PSCRIPTCONFIG:function(){}", $jsConfig, $js);
			
			file_put_contents("myapp-offline/jsengine/PScript/PScript.js", $js);


?>