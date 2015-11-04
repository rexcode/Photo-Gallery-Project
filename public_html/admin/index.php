<?php  
require_once('../../includes/initialize.php');
// from public/index.php
//require_once ('..\..\includes\functions.php');
//require_once ('..\..\includes\session.php');

if (!$session->is_logged_in()) { redirect_to("login.php"); }
// $photos = Photograph::find_all();
?>

<?php $photos = Photograph::find_all(); 
	// var_dump($photos);
	// echo "Hello";
?>

	<?php include '../layouts/admin_header.php'; ?>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    	<p><a class="navbar-brand text-muted" href="index.php">Photo Gallery: Admin</a></p>
      
      <div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="list_photos.php">List Photos</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li>
          <li><a href="logout.php">Logout</a></li>
          <li><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
        </ul>
      </div>
    </div>
  </div>
	<!-- <h2>Photo Collection</h2>
	<p></p>
	<p></p>
	<p></p>
	<p></p> -->

<!-- PHP way -->
	<?php //foreach ($photos as $photo) {
		// echo "";
		// echo '<a class=\'wrapper\' href = "../photo.php?id='.$photo->id."\" title=".$photo->filename."><span class=\"text\">
  //       &nbsp;&nbsp;&nbsp;Click on the image to see full image and comments
  //   </span><img class='photo' src = "."../".$photo->image_path()." width='200' height='150'></a>";
		// echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	//}
	?>
	<!-- html way -->
	<?php // foreach($photos as $photo): ?>
		<!-- <a href="photo.php?id=<?php // echo $photo->id; ?>">
			<img src="../<?php // echo $photo->image_path(); ?>" alt="<?php // echo $photo->filename; ?>" width = "200">
		</a>  -->
	<?php // endforeach; ?>
	
			!<?php  foreach($photos as $photo): ?>
			<div class="clearfix grid" style="">
			 <a  class = "wrapper" href="../photo.php?id=<?php echo $photo->id; ?>">
				<span class="text">
	        &nbsp;&nbsp;&nbsp;Click on the image to see full image and comments
	    </span>
				<img class="photo " id="photo" src="../<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->filename; ?>"  title="<?php echo $photo->caption; ?>">
			</a>
			<br><br>
			<p style=""><?php echo $photo->caption; ?></p>
			</div>

	<?php  endforeach; ?>
	<?php include '../layouts/admin_footer.php'; ?>
