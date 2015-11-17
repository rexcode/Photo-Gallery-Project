<?php  
//require_once '../../includes/photograph.php';
require_once '../../includes/initialize.php';


// table which retrieves data from Db and files uploaded
if (!$session->is_logged_in()) { 	return redirect_to ('login.php'); }
?>

<?php include '../layouts/admin_header.php'; 

// if (isset($_SESSION['delete_message'])){
//  	echo $_SESSION['delete_message']."<br>";
// 	unset($_SESSION['delete_message']);
// }


?>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    	<p><a class="navbar-brand text-muted" href="index.php">Photo Gallery<?php //echo (isset($user->username)) ?  $user->username : "Login"; ?></a></p>
      
      <div>
        <ul class="nav navbar-nav navbar-right">
        	<li><a href="index.php">Home</a></li>
        	<li><a href="list_photos.php">Photo Catalog</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li>
          <li><a href="logout.php">Logout</a></li>
        	<li><a href="#">Logged in as <?php echo $_SESSION['username']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

	
	<!-- <p>	<a href="index.php">Back</a><br><br></p>
	<p><a href="logfile.php">Log File</a></p>
	<p><a href="photo_upload.php">Upload Photo</a></p>
	<p><a href="list_photos.php">List Photos</a></p>
	<p><a href="logout.php">Logout</a></p>
	 -->
<?php  
	// Get all the entries from the photograph table as an object array
  // Each entry is retrieved as an object
	$photos = Photograph::find_all();
	// var_dump($photos);
	// echo "<hr>";
?>
<!-- <p>Hello</p> -->

<div class="container  margin grid">	
	<?php 
	if (isset($_SESSION['message'])){
		echo "<h3 class='text-center'>".$_SESSION['message']."</h3>";
		// echo "<h3 class=\'text-center\'>$_SESSION['message']</h3>";
 		unset($_SESSION['message']);
}
?>
	<br><br>	
	<h2>Uploaded Photographs List</h2>
	<p><small>( Dear <?php echo $_SESSION['username']; ?> you can only delete photos uploaded by you )</small></p>
<table  class = "table" border = "1px solid black" width="610px;" >
	<tr>
		<th>Image</th>
		<th>Filename</th>
		<th>Caption</th>
		<th>Uploader</th>
		<th>Type</th>
		<th>Size</th>
		<th>Action</th>
    	<th>Comments</th>
	</tr>
	<?php foreach ($photos as $photo) :?>
	<tr>
		<!-- We use an image path() so in case of upload directory change, this page will not break -->
		<!-- // SIMPLE WAY -->
		<!-- <td><img src="../<?php// echo $photo->upload_dir.'/'.$photo->filename; ?>" width="150"></td> -->
		<!-- // SECOND WAY -->
		<td><img class="photo" src="../<?php echo $photo->image_path(); ?>" width="150"></td>
		<td><?php echo $photo->filename; ?></td>
		<td><?php echo $photo->caption; ?></td>
		<td><?php echo $photo->uploader; ?></td>
		<td><?php echo $photo->type; ?></td>
		<td><?php echo $photo->size_as_text(); ?></td>
		<td>
			<?php if ($_SESSION['username'] == $photo->uploader) { ?>
				<a class="delete_photo btn btn-danger" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
			<?php  } else {  ?>
				<span class="btn btn-default" title="You are not authorised to delete <?php echo $photo->filename ?> as you have not uploaded it.">Deletion not allowed</span>
			<?php } ?>
		</td>
	  <td><a href="comments.php?id=<?php echo $photo->id; ?>"><?php echo count($photo->comments()); ?></a></td>
  </tr>
	<?php endforeach; ?>
	</table>
</div>
<?php include '../layouts/admin_footer.php'; ?>

<?php  
// public function image_path(){
// 	return $this->upload_dir."/".$this->filename;
// 	//$target_path = "../".$upload_dir."/".$this->filename;
//}

?>