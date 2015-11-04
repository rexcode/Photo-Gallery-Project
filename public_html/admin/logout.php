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
        	<li><a href="index.php">Home</a></li>
          <li><a href="list_photos.php">List Photos</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
        </ul>
      </div>
    </div>
  </div>
	<h1 class="margin center">You are now logged out.</h1>
	<p class="center"><a class="btn btn-info" href="login.php">Login</a></p>

<?php include '../layouts/admin_footer.php'; ?>