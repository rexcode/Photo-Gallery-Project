<?php  
// require just for backup - not needed
require_once ('database.php');

//User Class for performing sql queries 
class User extends DatabaseObject{
	protected static $table_name = "users";
	public static $db_fields = array('id', 'username', 'password', 'email','first_name', 'last_name');
	public $id;
	public $username;
	public $password;
	public $confirm_password;
	public $email;
	public $first_name;
	public $last_name;

	public function create_user($first_name, $last_name, $username, $password, $confirm_password)
	{	
		global $database;
		$errors = array();
		// $dfirst_name = "";
		// $dlast_name = "";
		// $dusername = "";
		// $dpassword = "";
		// $dconfirm_password = "";
		// $demail = "";
		
		if (empty($first_name)) {
			$errors[] = "You forgot to enter your first name.";
		} else {
			$first_name = $database->escape_value($first_name);
		}

		if (empty($last_name)) {
			$errors[] = "You forgot to enter your last name.";
		} else {
			$last_name = $database->escape_value($last_name);
		}

		if (empty($username)) {
			$errors[] = "You forgot to enter your username.";
		} else {
			$username = $database->escape_value($username);
		}

		if (empty($password)) {
			$errors[] = "You forget to enter your password.";
		} else {
			$password = $database->escape_value($password);
		}
		
		if (empty($confirm_password)) {
			$errors[] = "You forgot to enter your confirm password.";
		} else {
			$confirm_password = $database->escape_value($confirm_password);
		}

		if ($password !== $confirm_password) {
			$errors[] = "You password and confirm password do not match.";
		} else {
			$confirm_password = $database->escape_value($confirm_password);
		}
	
		if (empty($errors)) {
			
			$sql  = " INSERT INTO users ( username , password, first_name, last_name )  VALUES ( '$username', '$password', '$first_name', '$last_name' ) ";	

			 if($database->query($sql)){ //will return a true or false as this is an insert query...
		 	// get the last id inserted into the DB
					$this->id = $database->insert_id();
					$_SESSION['registered'] = "You have been successfully registered.";
					redirect_to('registration.php');
					return true;
			} else {
					return false;
			}
	
	 		} else {

	 			echo "<br><br><br><br><br><h4 class='text-center'>There were some errors!</h4>\n
				<p class='text-center'>The following error(s) occurred: ><br>";	
				foreach ($errors as $error) {
					echo " - $error<br>\n";
				}
				echo "</p>";
			}
	}
	
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