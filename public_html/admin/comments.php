<?php  
require_once '../../includes/initialize.php';

if (!$session->is_logged_in()) { redirect_to ('login.php'); }

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
 
// You can have a comment submission and processing here if u want ...
// Getting all the comments regarding this photograph..
//
  $comments = $photo->comments();
  // $comments = Comment::find_comments_on($photo->id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comments</title>
</head>
<body>
	<?php include '../layouts/admin_header.php'; ?>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <p><a class="navbar-brand text-muted" href="index.php">Photo Gallery: Admin</a></p>
      <div>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Home</a></li>
          <li><a href="list_photos.php">List Photos</a></li>
          <li><a href="photo_upload.php">Upload Photo</a></li>
          <li><a href="logfile.php">Log File</a></li>
          <li><a href="logout.php">Logout</a></li>
          <li><a href="#">&nbsp;&nbsp;  </a></li>
        </ul>
      </div>
    </div>
  </div>
	<a href="list_photos.php">&laquo; Back</a>
	<br><br>
	<!-- list of comments -->
  <div id = "comments" class="panel panel-default container">

  <h2>Comments on <?php echo $photo->filename; ?></h2>
  <hr>
  <p><?php if (isset($_SESSION['message'])) { echo $_SESSION['message'];  } ?></p>
    <?php foreach($comments as $comment): ?>
        <div class = "comment">
          <p><span class=" author"><?php echo htmlspecialchars($comment->author); ?></span> wrote : </p>
          <p><?php echo strip_tags($comment->body, '<stronng><em><p>'); ?></p>
          <p><?php echo datetime_to_text($comment->created); ?></p>
          <p><a id= "delete_comment" class= "delete_comment btn btn-danger" href="delete_comment.php?comment_id=<?php echo $comment->id; ?>">Delete Comment</a></p>
        </div>
        <hr>
    <?php endforeach; ?>
    <?php if (empty($comments)) { echo '<p style = "font-style:italic;">No comments.</p>'; } ?>
      <p class="photo-link"><a class="btn btn-success" href="../photo.php?id=<?php echo $photo->id; ?>">Add a comment</a></p>
  </div>
	<?php include '../layouts/admin_footer.php'; ?>
</body>
</html>