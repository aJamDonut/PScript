<?php

class PScript_Blocks {
	
	public $data = array();
	
	function data($data) {
		
		$this->data = array_merge($this->data, $data);
		
	}
	
	function get($block, $MyPhp=false) {
		$Blocks = $this;
		require("myapp/blocks/{$block}.phtml");
		
	}
	
	function plugin($plugin, $block, $MyPhp=false) {
		$Blocks = $this;
		require("plugins/{$plugin}/blocks/{$block}.phtml");
		
	}
	
}

?>