<?php  
// require just for backup - not needed
require_once ('database.php');

//User Class for performing sql queries 
class User extends DatabaseObject{
	protected static $table_name = "users";
	public static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	
	public static function authenicate($username="", $password=""){
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);

		//$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
		$sql  = "SELECT * FROM users"; 
		$sql .= " WHERE username = '$username'"; 
		$sql .= " AND password = '$password'"; 
		$sql .= " LIMIT 1";

		$result_array = static::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false ;
	}

	public function full_name(){ 
	// this is very difficult to do with an array like $result/$row
		if (isset($this->first_name) && isset($this->last_name)) {
				return $this->first_name." ".$this->last_name; 
		} else {
			return "";
		}
	}


// COMMON DATABASE METHODS
}