<?php  
require_once('../../includes/initialize.php');

if (!$session->is_logged_in()) { redirect_to("login.php"); }

if (empty($_GET['comment_id'])) {
	$_SESSION['message'] = "Comment id was not found..";
	redirect_to('index.php');
}

$comment = Comment::find_by_id($_GET['comment_id']);
if ($comment && $comment->delete()) { // we use the object to delete the entry from DB
	$_SESSION['message'] = "The comment has been deleted..";
  // from DB the comment has been deleted but its instance still exists
  // which is used here to refer to photogrph id.
	redirect_to("comments.php?id={$comment->photograph_id}");
} else {
	$_SESSION['message'] = "The comment was not deleted..";
	redirect_to('list_photos.php');
}

