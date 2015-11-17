<?php  
// defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);

require_once '../../includes/initialize.php';

if($session->is_logged_in()) { 
	redirect_to("index.php"); 
}
//Give form's submit tag name = "submit"
if (isset($_POST['submit'])) {

	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);
	// $email = trim($_POST['email']);

	$user = new User();
	// var_dump($user);	
	$user->create_user($first_name, $last_name, $username, $password, $confirm_password);
	
} else { // Form has not been submitted
	$first_name = "";
	$last_name = "";
	$username = "";
	$password = "";
	$confirm_password = "";
	// $email = "";
	echo "Fail";
}
?>
<?php  include '../layouts/admin_header.php'; ?>
	<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <p><a class="navbar-brand text-muted" href="index.php">Photo Gallery</a></p>      
      <div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Home</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container margin">

	  <?php // if (isset($_SESSION['registered'])) {
  	// echo "<h3 class='text-center'>".$_SESSION['registered']."</h3>";
  	// unset($_SESSION['registered']);
  	// } ?>
		<br>
		<h2>Please enter following details.</h2>
		<form action="registration.php" method="post">
			<table class="login">
				<tr>
					<td><b>First Name</b> &nbsp;</td>
					<td><input type="text" name="first_name" maxlength="30" 
				 value="<?php echo htmlentities($first_name); ?>"></td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>

				<tr>
					<td><b>Last Name</b> &nbsp;</td>
					<td><input type="text" name="last_name" maxlength="30" 
				 value="<?php echo htmlentities($last_name); ?>"></td>
				</tr>
				
				<tr><td>&nbsp;</td></tr>	

				<tr>
					<td><b>Username</b> &nbsp;</td>
					<td><input type="text" name="username" maxlength="30" 
				 value="<?php echo htmlentities($username); ?>"></td>
				</tr>
						
				<tr><td>&nbsp;</td></tr>

				<tr>
					<td><b>Password</b> &nbsp;</td>
					<td><input type="password" name="password" maxlength="30" value="" ></td>
				</tr>

				<tr><td>&nbsp;</td></tr>

				<tr>
					<td><b>Confirm Password</b> &nbsp;</td>
					<td><input type="password" name="confirm_password" maxlength="30" value=""></td>
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