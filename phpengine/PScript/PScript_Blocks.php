<?php

class PScript_Blocks {
	
	function get($block, $MyPhp=false) {
		require("myapp/blocks/{$block}.phtml");
		
	}
	
	function plugin($plugin, $block, $MyPhp=false) {
		require("plugins/{$plugin}/blocks/{$block}.phtml");
		
	}
	
}

?>