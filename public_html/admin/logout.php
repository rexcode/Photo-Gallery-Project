<?php  
require_once '../../includes/session.php';

if ($session->is_logged_in()) {
	$session->logout();

}

include '../layouts/admin_header.php';

?>
	<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    	<p><a class="navbar-brand text-muted" href="../index.php">Photo Gallery</a></p>      
      <div>
        <ul class="nav navbar-nav navbar-right">
        	<li><a href="../index.php">Home</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="registration.php">Register</a></li>
        </ul>
      </div>
    </div>
  </div>
  <br><br><br><br>
	<h2 class="margin center">You are now logged out.</h2><br>
	<p class="center"><a class="btn btn-info" href="login.php">Login</a></p>

<?php include '../layouts/admin_footer.php'; ?>