<?php  
require_once('../../includes/initialize.php');
// require_once('../../includes/session.php');
//
//require_once('../../includes/functions.php');
//require_once('../../includes/session.php');
// from public/index.php
//require_once ('..\..\includes\functions.php');
//require_once ('..\..\includes\session.php');

if (!$session->is_logged_in()) { redirect_to("login.php"); }

include '../layouts/admin_header.php';
?>

<?php 
// Create a new User 
// $user = new User();
// $user->username = "Bhoomika";
// $user->password = "bhoomika";
// $user->first_name = "Bhoomika";
// $user->last_name = "Joshi";

// $user->create();


//Update an existing User
// $user = User::find_by_id(11); // ths returns an the user (single row) as an object
// $user->password = "joshipatel123";
// //if user->id is set do an update or do an insert...

//  $user->save(); // for update or create a new user

//DELETE AN EXISTING USER
// $user = User::find_by_id(5);
// echo $user->id;
// $user->delete();

?>

<?php include '../layouts/admin_footer.php'; ?>