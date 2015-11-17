<?php  
 // error_reporting(E_ERROR | E_PARSE); // Works - removes the error notice

require_once '../../includes/initialize.php';

// check whether the user is logged in or not....
if (!$session->is_logged_in()) {
	redirect_to ('index.php');
}

$file = "../../logs/log.txt"; // Be very careful here

// This produces an undefined index error....
//if ($_GET['clear'] == 'true') {

if (isset($_GET['clear']) && ($_GET['clear'] == 'true')) { // This works OK..

	// U R repeating urself here....

	// if (file_exists($file) && is_readable($file)) {
	// if ($handle = fopen($file, 'w')) {
	// 	$content = "Logs were cleared...\n";
	// 	fwrite($handle, $content);
	// fclose($handle);
	// } else {
	// 	echo "file could not be accessed..";
	// }

	// Smaller --DRY-- way
	// reset the logfile.
	file_put_contents($file, "");
	// Add the first log file enrty
	log_action("Logs Cleared", "by {$session->username}");
	// redirect the same page, so url won't have
	// "clear=true" query anymore..
	redirect_to('logfile.php');
}
?>

<?php include '../layouts/admin_header.php'; ?>
	<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <p><a class="navbar-brand text-muted" href="index.php">Photo Gallery: Admin</a></p>      
      <div>
        <ul class="nav navbar-nav navbar-right">
        	<li><a href="admin/index.php">Home</a></li>
        	<li><a href="list_photos.php">Photo Catalog</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li>
          <li><a href="logout.php">Logout</a></li>
        	<li><a href="#">Logged in as <?php echo $_SESSION['username']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>
	<br><br><br>	
	<h2 class="container margin">Log File</h2>
	<p class="center">Log file displays the record of logins of the users and admin</p><br>
	<p><a class="btn btn-success" href="index.php">&laquo; &nbsp; Back</a>
	<?php if ($_SESSION['username'] == 'admin'){ ?>
		<a class=" delete_log_file btn btn-warning"href="logfile.php?clear=true">Clear the log File</a></p>
	<?php } else { ?>	
		<span class=" btn btn-default">Only admin can clear this file.</span>
	<?php } ?>

<?php  
//$content ="";

if (file_exists($file) && is_readable($file) && $handle = fopen($file, 'r')) {
	//if ($handle = fopen($file, 'r')) {
		echo "<ul>";
		while (!feof($handle)) {
			$entry = fgets($handle); // fgets automatically adds \n - new line.
			// fgets() returns on new entry at a time..
				if (trim($entry) != "") { // if empty ignore it and goto next line
				echo "<li>{$entry}</li>";
			}
		}
		echo "</ul>";
		fclose($handle);

	// Alternate way
	// if($handle = fopen($file, 'r')) {  // read
  // $content = fread($handle, filesize($file));
  // fclose($handle);
	// }
	} else {
			echo "File could not be read.";
		}
// }

// echo nl2br($content);
// echo is_array($content) ? 'yes' : 'NO'; // NO

include '../layouts/admin_footer.php'; 
