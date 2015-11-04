<?php  

class Session {

	private $logged_in = false; // only Session class can change this...
	// depnding on which methods are called.
	public $user_id;
	public $message;

function __construct()
{
	// Make a new session obect and start the session
	session_start();
	$this->check_login(); // check if the user isl logged in

	//We could take addl. action here if needed
	// if ($this->logged_in){
	// 	// do this ....
	// } else {
	// 	// or do this ...
	// }

}
// Check if the user is already logged in....
public function check_login()
{
	if (isset($_SESSION['user_id'])) { // cans use session['agent'] for better security...
		$this->logged_in = true;
		$this->user_id = $_SESSION['user_id'];
	} else {
		unset($this->user_id);
		$this->logged_in = false;
	}
}

// Username and password already verified so log the user in...
public function login($user)
{	
	if ($user) {
		$this->logged_in = true;
		$this->user_id = $_SESSION['user_id'] = $user->id;
	}
	
}

public function logout()
{
	unset($_SESSION['user_id']);
	unset($this->user_id);
	$this->logged_in = false;
}

public function is_logged_in(){
	return $this->logged_in;
}

}

// Initialize the Session class
$session = new Session();
