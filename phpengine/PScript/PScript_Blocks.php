<?php

class PScript_Blocks {
	
	function get($block, $MyPhp=false) {
		require("myapp/blocks/{$block}.phtml");
		
	}
	
	
}

?>