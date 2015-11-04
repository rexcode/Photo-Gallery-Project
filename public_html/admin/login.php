<?php  
// defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);

require_once '../../includes/initialize.php';

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
		redirect_to("index.php");
	} else {
		echo  "username / password was not found in the database.";
	}

} else { // Form has not been submitted
	$username = "";
	$password = "";
}
?>
<?php  include '../layouts/admin_header.php'; ?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <p><a class="navbar-brand text-muted" href="index.php">Photo Gallery: Admin</a></p>      
      <div>
        <ul class="nav navbar-nav navbar-right">
        	<!-- <li><a href="admin/index.php">Home</a></li>
          <li><a href="list_photos.php">List Photos</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li> -->
          <!-- <li><a href="login.php">Login</a></li> -->
          <li><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container margin">
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
		</table>
				<!-- <input type="text" name="submit" value="submit"> -->
	</form>
	</div>
	
<?php include '../layouts/admin_footer.php'; ?>	