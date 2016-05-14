<?php

class contact {
	
	public function validate($form) {
		
		$errors = false;
		
		if($form['name']=="") {
			$errors['name'] = "You must enter a name";
		}
		
		if($errors == false) {
			return true;
		}
		
		return $errors;
		
	}

}

?>