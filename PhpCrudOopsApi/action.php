<?php

// action.php

include_once('crud.php');
include_once('validation.php');

$object = new CrudOperations();
$validate = new Validation();

if (isset($_POST["action"]) || isset($_GET["action"])){

	// query to fetch data

	if($_POST["action"] == "Fetch"){
		echo $object->getData("SELECT * FROM users ORDER BY user_id DESC");
	}

	// query to insert data

	if($_POST["action"] == "Insert"){

		$name = mysqli_real_escape_string($object->connect,$_POST["username"]);
		$email = mysqli_real_escape_string($object->connect,$_POST["email"]);
		$mobile_num = mysqli_real_escape_string($object->connect,$_POST["mobile"]);

		$msg = $validate->check_empty($_POST,array('username','email','mobile'));
		$check_name = $validate->is_name_valid($name);
		$check_number = $validate->is_mobile_num_valid($mobile_num);
		$check_email = $validate->is_email_valid($email);

		if ($msg!=null){
			$empty_err = "Fields are empty";
		}
		elseif (!$check_name) {
			$invalid_name_err = "Invaid name";
		}
		elseif (!$check_number){
			$invalid_number = 'Please provide proper number';
		}
		elseif (!$check_email){
			$invalid_mail = 'Email not valid';
		}
		else{
			$insert_query = "
			INSERT INTO users 
			(user_name, user_email, user_mobile_num)
			VALUES('".$name."','".$email."','".$mobile_num."')
			";
			$object->execute_query($insert_query);
			echo 'Data inserted';
		}
	}

	// query to fetch single row to edit

	if ($_POST["action"] == "Fetch_single"){

		$output = '';
		$fetch_query = "SELECT * FROM users WHERE user_id ='".$_POST['user_id']."'";
		$result = $object->execute_query($fetch_query);
		while ($row = mysqli_fetch_array($result)){
			$output["username"] = $row["user_name"];
			$output["email"] = $row["user_email"];
			$output["mobile_num"] = $row["user_mobile_num"];
		}
		echo json_encode($output);
	}

	// query to update data

	if($_POST["action"] == "Update"){
	
		$name = mysqli_real_escape_string($object->connect, $_POST["username"]);
		$email = mysqli_real_escape_string($object->connect, $_POST["email"]);
		$mobile_num = mysqli_real_escape_string($object->connect, $_POST["mobile"]);


		$msg = $validate->check_empty($_POST,array('username','email','mobile'));
		$check_name = $validate->is_name_valid($name);
		$check_number = $validate->is_mobile_num_valid($mobile_num);
		$check_email = $validate->is_email_valid($email);

		if ($msg != null){
			$empty_err="Fields are empty";
		}elseif (!$check_name) {
			$invalid_name_err = "Invalid name";
		}
		elseif (!$check_number){
			$invalid_number = 'Please provide proper number';
		}
		elseif (!$check_email){
			$invalid_mail = 'Email not valid';
		}
		else {
			$query = "UPDATE users SET 
			user_name = '$name', user_email='$email', user_mobile_num = '$mobile_num' 
			WHERE user_id = '".$_POST['hidden_id']."' ";
			$object->execute_query($query);
			echo 'Data Updated';
		}

		
	}

	// query to delete data

	if ($_POST["action"] == "Delete"){
		$delete_query = "DELETE FROM users WHERE user_id='".$_POST['id']."' ";
		$object->execute_query($delete_query);
		echo "Deleted Successfully";
	}
}

?>