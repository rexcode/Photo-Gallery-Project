<?php  
require_once '../includes/initialize.php';

// if (!$session->is_logged_in()) { redirect_to ('login.php'); }

// checking if an id received or not..
if (empty($_GET['id'])) { 
	$_SESSION['message'] = "Photograph ID not found or provided...";
	redirect_to ('index.php'); 
}

// find all photographs using static fn and id received..
$photo = Photograph::find_by_id($_GET['id']);
// checking if photo found or not
if (!$photo) {
  $_SESSION['message'] = "The photo could not be located.";
  redirect_to ('index.php');  
}

if (isset($_POST['submit'])) {
	$author = trim($_POST['author']);
	$body = trim($_POST['body']);

	// Instantiate a comment object
	$new_comment = Comment::make($photo->id, $author, $body);

	// Saving the new comment in DB..
	if ($new_comment && $new_comment->save()) {
		// Success - comment saved
		// No success message as comment will be seen.

    // When the page is reloaded  the form will try 
    // to re-submit the comment.. So redirect instead...
    // Will unset the author and body $vars.
		redirect_to("photo.php?id={$photo->id}");
	} else {
    // we can create an errors array in comment->save()
			$errors = "The comment could not be saved...";
	}
} else {

$author = "";
$body =  "";
$errors = "";
}

// Getting all the comments regarding this photogrph..
//
  $comments = $photo->comments();
  // $comments = Comment::find_comments_on($photo->id);
?>

	<?php include 'layouts/header.php'; ?>
	<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
    	<?php if ($session->is_logged_in()) { ?>
    	<p><a class="navbar-brand text-muted" href="index.php">Photo Gallery: Admin</a></p>
			<?php } else { ?>
    	<p><a class="navbar-brand text-muted" href="index.php">Photo Gallery</a></p>
    	<?php } ?>
        <div>
        <?php if ($session->is_logged_in()) { ?>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="admin/index.php">Home</a></li>
          <li><a href="admin/list_photos.php">Photo Catalog</a></li>
          <li><a href="admin/photo_upload.php">Upload Photo</a></li>
          <li><a href="admin/logfile.php">Log File</a></li>
          <li><a href="admin/logout.php">Logout</a></li>
          <li><a href="#">Logged in as <?php echo $_SESSION['username']; ?></a></li>
        </ul>
        <?php } else { ?>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="admin/login.php">Login</a></li>
            <li><a href="admin/registration.php">Register</a></li>
          </ul>
        <?php } ?>

        
      </div>
    </div>
  </div>

	<div class="margin container">
	<a class="btn btn-success" href="index.php">&laquo; Back</a>
	<br><br>
	<div style="margin-left:20px;">
	<img src="<?php echo $photo->image_path(); ?>" alt="<?php echo $photo->filename; ?>" width="950" height="600">
	<br><br>
	<h3 style=""><?php echo $photo->caption; ?></h3>
  </div>

	<!-- list of comments -->
  <div class="margin container panel panel-default" id = "comments">
  <h2>Comments on <?php echo $photo->filename; ?></h2>
  <hr>
    <?php foreach($comments as $comment): ?>
        <div style="margin-left:25px; margin-bottom:2em; ">
          <p><span style="font-weight: bold;"><?php echo htmlspecialchars($comment->author); ?></span> wrote : </p>
          <p><?php echo strip_tags($comment->body, '<stronng><em><p>'); ?></p>
          <p><?php echo datetime_to_text($comment->created); ?></p>
        </div>
      <hr>  
    <?php endforeach; ?>
    <?php if (empty($comments)) { echo '<p style = "font-style:italic;">Be the first to post a comment.</p>'; } ?>
  </div>

<!-- Comment Form  -->
<div  class = "left" id = "comment-form">
	<h3>New Comment</h3>
	<?php echo $errors; ?>
  <form  class = "clearfix left" action="photo.php?id=<?php echo $photo->id; ?>" method="POST">
		<table>
			<tr><td>Your Name </td>
			<td><input type="text" name="author" value="<?php echo $author; ?>"></td>
			</tr>
			<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			<tr>
				<td>Your Comment &nbsp;</td>
				<td><textarea name="body" cols = "30" row = "8"><?php echo $body; ?></textarea></td>
			</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>	
			<tr>
				<td>&nbsp;</td>
				<td><input  class="btn btn-primary" type="submit" name="submit" value="Submit Comment"></td>
			</tr>
		</table>
	</form>
</div>
</div>
	<?php include 'layouts/footer.php'; ?>
