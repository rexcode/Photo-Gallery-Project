<?php  
require_once '../includes/initialize.php';

// Set the $current_page
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// no. of records to show per page
$per_page = 8;

// Total no. of records in the given table
$total_count = Photograph::count_all();

// create a new pagination object and pass all the 3 vars...
$pagination = new Pagination($page, $per_page, $total_count);

// Insert Pagination - we fetch only limited records using offset to go to next page
$sql  = "SELECT * FROM photographs ";
$sql .= "LIMIT $per_page ";
$sql .= "OFFSET {$pagination->offset()}"; //{} must for a function call inside a string.
// Grab the records from the DB
$photos = Photograph::find_by_sql($sql);

?>
<?php include 'layouts/header.php'; ?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    <p><a class="navbar-brand text-muted" href="index.php">Photo Gallery</a></p>      
      <div>
      	<?php if ($session->is_logged_in()) { ?>
        <ul class="nav navbar-nav navbar-right">
					<li><a href="admin/index.php">Home</a></li>
          <li><a href="list_photos.php">Photo Catalog</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li>
          <li><a href="admin/logout.php">Logout</a></li>
        	<li><a href="#">Logged in as <?php echo $_SESSION['username']; ?></a></li>        </ul>
        <?php } else { ?>
        	<ul class="nav navbar-nav navbar-right">
        		<li><a href="admin/login.php">Login</a></li>
        		<li><a href="admin/registration.php">Register</a></li>
        	</ul>
        <?php } ?>	 
      </div>
    </div>
  </div>
<!-- html way -->
	<?php  foreach($photos as $photo): ?>
		<div class="clearfix grid" style="float: left; margin-left:30px;">
		 <a  class = "wrapper" href="photo.php?id=<?php echo $photo->id; ?>" >
			<span class="text">
        &nbsp;&nbsp;&nbsp;Click on the image to see full image and comments
    </span>
			<img class="photo " id="photo" src="<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->filename; ?>" width = "200" height="150" title="<?php echo $photo->caption; ?>">
		</a>
		</div>

	<?php  endforeach; ?>

	<hr>
	
	<!-- // pagination links -->
	
	<div class="container margin" id="pagination" style="clear: both;">
	<br><br>
	<?php 
	if ($pagination->total_pages() > 1){

		if ($pagination->has_previous_page()) {
			echo "<a href=\"index.php?page=";
			echo $pagination->previous_page();
			echo "\">&nbsp;Previous </a>&nbsp;";
		}

		for ($i = 1; $i <= $pagination->total_pages
			(); $i++) { 
			if ($i == $page) {
				echo "<span class=\"selected\">&nbsp; $i </span>";
			} else {
				echo "<a href=\"index.php?page=$i\">&nbsp; $i </a>";
			}
		}

		if ($pagination->has_next_page()) {
			echo "<a href=\"index.php?page=";
			echo $pagination->next_page();
			echo "\">&nbsp; Next </a>";
		}
	}
	?>
 </div>

 <div class="container">
 	<hr class="hr-dark"> 
 	<p class="text-center">Photo Gallery is a photo blog which allow users to
 	upload their  photos.	</p>
 </div>

<?php include 'layouts/footer.php'; ?>
