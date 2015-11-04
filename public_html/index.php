<?php  
require_once '../includes/initialize.php';

// Set the $current_page
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// no. of records to show per page
$per_page = 2;

// Total no. of records in the given table
$total_count = Photograph::count_all();

// create a new pagination object and pass all the 3 vars...
$pagination = new Pagination($page, $per_page, $total_count);

// This is not pagination as all records are fetched...
// $photos = Photograph::find_all(); 
// var_dump($photos);
// echo "Hello";

// We use pagination instead of find_all();

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
          <li><a href="admin/list_photos.php">List Photos</a></li>
          <li><a href="admin/photo_upload.php">Upload Photo</a></li>
          <li><a href="admin/logfile.php">Log File</a></li>
          <li><a href="admin/logout.php">Logout</a></li>
          <li><a href="#">&nbsp;&nbsp;&nbsp;</a></li>
        </ul>
        <?php } else { ?>
        	<ul class="nav navbar-nav navbar-right">
        		<li><a href="admin/login.php">Login</a></li>
        	</ul>
        <?php } ?>	 
      </div>
    </div>
  </div>

<!-- 	<h2>Photo Collection</h2>
	<p><a href="admin/logfile.php">Log File</a></p>
	<p><a href="admin/photo_upload.php">Upload Photo</a></p>
	<p><a href="admin/list_photos.php">List Photos</a></p>
	<p><a href="admin/logout.php">Logout</a></p>
 -->	
	<?php // print_r(gd_info()); ?>
  <!-- PHP way -->
  	<?php // foreach ($photos as $photo) {
  	// 	echo "";
  	// 	echo '<a href = "photo.php?id='.$photo->id."\" title=".$photo->filename."><img src = ".$photo->image_path()." width='200'></a>";
  	// 	echo "&nbsp;&nbsp;";
  	// } 
	?>

<!-- html way -->
	<?php  foreach($photos as $photo): ?>
		<div class="clearfix grid" style="float: left; margin-left:30px;">
		 <a  class = "wrapper" href="photo.php?id=<?php echo $photo->id; ?>" >
			<span class="text">
        &nbsp;&nbsp;&nbsp;Click on the image to see full image and comments
    </span>
			<img class="photo " id="photo" src="<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->filename; ?>" width = "200" height="150" title="<?php echo $photo->caption; ?>">
		</a>
		<!-- <p style="text-align: center;"><?php echo $photo->caption; ?></p> -->
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
<?php include 'layouts/footer.php'; ?>
