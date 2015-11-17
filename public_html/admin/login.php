<?php  
// defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);

require_once '../../includes/initialize.php';
include '../layouts/admin_header.php'; 

if($session->is_logged_in()) { 
	redirect_to("index.php"); 
}
//Give form's submit tag name = "submit"
if (isset($_POST['submit'])) {
	// echo "Form submitted.";
	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	// Check database if username and password  found in DB
	$found_user = User::authenicate($username, $password);

	//  We can do some more checking here -- like subscription time and
	// then log them in...

	if ($found_user) {
		$session->login($found_user);
		log_action("Login", "{$found_user->full_name()} Logged in.");
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		redirect_to("index.php");
	} else {
		$error_message =  "<br><br>username / password was not found in the database.";
	}

} else { // Form has not been submitted
	$username = "";
	$password = "";
}
?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <p><a class="navbar-brand text-muted" href="index.php">Photo Gallery</a></p>      
      <div>
        <ul class="nav navbar-nav navbar-right">
        	<li><a href="../index.php">Home</a></li>
        	<li><a href="registration.php">Register</a></li>
          <li><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container margin">

  <?php if (isset($error_message)) {
  	echo "<h4 class='text-center'>$error_message</h4>";
  } ?>
  <br><br>
	<h2>Please enter your login details.</h2>
	<form action="" method="post">
		<table class="login">
			<tr>
				<td><b>Username</b> &nbsp;</td>
				<td><input type="text" name="username" maxlength="30" 
			 value="<?php echo htmlentities($username); ?>"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td><b>Password</b> &nbsp;</td>
				<td><input type="password" name="password" maxlength="30" 
		   value="<?php if (isset($password)) { echo htmlentities($password);	}; ?>"></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2"><button class="btn btn-primary" name = "submit">Submit</button></td>	
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2"><a href="registration.php">Register</a></td>
			</tr>
		</table>
				<!-- <input type="text" name="submit" value="submit"> -->
	</form>
	</div>
	<hr class="hr-dark">	
	<div class="container">
	 	<p class="text-center">Photo Gallery is a photo blog which allow users to
	 	upload and delete their photos and add comments. 	</p>
	 	<p class="text-center">They can also see photos uploaded by others and comment on them.</p>
 </div>
	
<?php include '../layouts/admin_footer.php'; ?>	