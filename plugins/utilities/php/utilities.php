<?php

class utilities {
	
	public function dirToArray($dir, $level = 1, $maxLevel = 5) {
		$dire = scandir($dir);
	
		$folders = array();
		$files = array();
		foreach ($dire as $f) {
			if ($f != "." && $f != "..") {
				if (strpos($f, ".") === false && is_dir($dir . "/" . $f)) {
					if ($level < $maxLevel) {
						
						$folders[$f] = $this::dirToArray($dir . "/" . $f, $level + 1);
					} else {
						$folders[$f] = array();
					}
				} else {
					//Ignore annoying mac BS.
					if (strpos(".DS_Store", $f) === false) {
						$files[] = $f;
					}
				}
			}
	
		}
	
		return array_merge($folders, $files);
	}

}

?>