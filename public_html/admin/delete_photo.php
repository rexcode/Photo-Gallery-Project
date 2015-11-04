<?php  
require_once('../../includes/initialize.php');

if (!$session->is_logged_in()) { redirect_to("login.php"); }

if (empty($_GET['id'])) {
	$_SESSION['message'] = "File was not found..";
	redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if ($photo && $photo->destroy()) {
	$_SESSION['message'] = "File $photo->filename was deleted..";
	redirect_to('list_photos.php');
} else {
	$_SESSION['message'] = "File $photo->filename was not deleted..";
	redirect_to('list_photos.php');
}

