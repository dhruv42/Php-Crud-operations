<?php
// crud.php

class CrudOperations{

	private $host = "localhost";
	private $username = "root";
	private $password = '';
	private $dbname = "task";

	public $connect;

	function __construct(){
		$this->database_connect();
	}

	// connection to the database
	public function database_connect(){
		$this->connect = mysqli_connect($this->host,$this->username,$this->password,$this->dbname);
	}

	// executes query
	public function execute_query($query){
		return mysqli_query($this->connect,$query);
	}

	// fetching data from database
	public function getData($query){
		$output='';
		$result=$this->execute_query($query);
		if(mysqli_num_rows($result)>0){
			while($row = mysqli_fetch_object($result)){
			$output.='
				<tr>
				<td>'.$row->user_name.'</td>
				<td>'.$row->user_email.'</td>
				<td>'.$row->user_mobile_num.'</td>
				<td><button type="button" name="edit" class="btn btn-success btn-xs update" id="'.$row->user_id.'">Edit</button></td>
				<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->user_id.'">Delete</button></td>
				</tr>
			';
			}
		}
		else{
			$output .= '
				<tr>
					<td colspan="6" align="center"><h4>No Data Found</h4></td>
				</tr>
			';
		}
		return $output;
	}
}

?>