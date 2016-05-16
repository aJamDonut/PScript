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
		global $_CONFIG;
		//Set $Theme to simplify for users
		$Theme = $this;
		if($this->theme ==false || $this->theme=='') {
			$this->theme = $_CONFIG['theme'];
		}
		$Blocks = new PScript_Blocks();
		require("myapp" . FS ."theme" . FS . $this->theme . FS . "master.phtml");
		
	}
	
		public function outputPlugin($plugin, $output) {
		
		//Set $Theme to simplify for users
		$Theme = $this;
		
		require("plugins". FS. $plugin . FS ."theme" . FS . $this->theme . FS . "master.phtml");
		
	}
	
	public function getHead() {
		global $_CONFIG;
		$this->headElements[] = <<<EOT
		<script type="text/javascript">
			var remoteURI = '{$_CONFIG['remote_url']}';
		</script>
EOT;
		
		
		foreach($this->headElements as $element) {
			echo $element;
		}
		
	}
	
	
	public function getBody() {
		
		echo "here we go!!";
		
	}
	
	
}

?>