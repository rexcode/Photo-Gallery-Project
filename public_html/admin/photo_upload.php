<?php  
require_once '../../includes/initialize.php';
// require_once '../../includes/photograph.php';

if (!$session->is_logged_in()) { redirect_to('login.php'); }

// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";

$max_file_size = 1048576;
$message = "";

if(isset($_POST['submit']) && isset($_FILES['file_upload'])) {

// if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit']) && isset($_FILES['file_upload'])) {
	$photo = new Photograph();
	$photo->caption = $_POST['caption'];
	$photo->uploader = $_POST['uploader'];

	$photo->attach_file($_FILES['file_upload']);
	// echo " file -upload.php ok <br>";
	// errors from attach_files method are again checked in save().

	if ($photo->save()) { // Success
		$_SESSION['message'] = "File {$photo->filename} uploaded successfully.";
		redirect_to('list_photos.php');
	} else { // failure
		$message = join("<br>", $photo->errors);
	}
}
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Upload a Photo</title>
	</head>
	<body>
	<?php include'../layouts/admin_header.php'; ?>

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

	<?php // echo output_message($message); ?>
	<?php //if ($message != "") {echo "<br>".$message."<hr>";} ?>
	<?php// if ($errors != "") { echo $errors;} ?>
	
	<br>
	<div class="container">
	<?php if ($message != "") {echo "<br><br><br>".$message."<hr class='panel'>";} ?>
			<!-- <p><a class="btn btn-success" href="index.php">Back</a></p> -->

			<form class="form" action="" enctype="multipart/form-data" method="POST">
			  <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
			  <input type="hidden" name="uploader" 
			  value="<?php echo $_SESSION['username']; ?>" >
			  <h3 class="file_upload">Choose the file to upload</h3><br>
			  <input class="btn btn-success" type="file" name="file_upload" /><br>
			<p>Caption : <input type="text" name="caption" value="" size="23"	 placeholder="Please enter photo caption"></p>
			<p class="center"><input class="btn btn-success" type="submit" name="submit" value="Upload" /></p>
			</form>
			<!-- "<?php // echo $_SESSION['username']; ?>" -->
	</div>

	<?php // echo $message; ?>

	<?php include'../layouts/admin_footer.php'; ?>
	</body>
	</html>	

