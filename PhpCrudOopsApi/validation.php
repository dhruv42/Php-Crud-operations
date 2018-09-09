<?php
// validation.php

class Validation{

	
	public function check_empty($data,$fields){
		$msg = null;
		foreach ($fields as $value){
			if (empty($data[$value])){
				$msg .= "$value field is empty<br>";
			}
		}
		return $msg;
	}

	public function is_name_valid($name){
		if (!is_numeric($name) && preg_match("/^[a-zA-Z][a-zA-Z ]*$/", $name)){
			return true;
		}
		return false;
	}

	public function is_mobile_num_valid($mobile_num){
		if (preg_match("/^[6-9][0-9]{9}$/", $mobile_num)){
			return true;
		}
		if (strlen((string)$mobile_num) == 10){
			return true;
		}
		return false;
	}

	public function is_email_valid($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
		}
		return false;
	}
}
?>