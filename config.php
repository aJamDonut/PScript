<?php

//Don't touch this line it's fine as it is and it isn't causing your problem aslong as index.php includes this file.
if(!$_pScript){echo 'Direct access not allowed';exit;}

$_CONFIG = array();

$_CONFIG['theme']      = "default";
$_CONFIG['remote_url'] = "www.bespoketeam.com"; //Offline apps will go here for live requests
$_CONFIG['live_url']   = "www.bespoketeam.com"; //Online apps will go here for the frontend
$_CONFIG['pscript_url']= "/";

?>