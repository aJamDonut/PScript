<?php

class PScript_Theme {
	
	private $theme = "default";
	private $body = "";
	private $headElements = array();
	
	
	public function setTheme($theme) {
		
		$this->theme = $theme;
		
	}
	
	public function addToHead($element) {
		$this->headElements[] = $element;
	}
	
	public function output($output) {
		
		//Set $Theme to simplify for users
		$Theme = $this;
		
		require("myapp" . FS ."theme" . FS . $this->theme . FS . "master.phtml");
		
	}
	
	public function getHead() {
		
		foreach($this->headElements as $element) {
			echo $element;
		}
		
	}
	
	
	public function getBody() {
		
		echo "here we go!!";
		
	}
	
	
}

?>