<?php

class PScript_Blocks {
	
	function get($block) {
		
		require("myapp/blocks/{$block}.phtml");
		
	}
	
	
}

?>