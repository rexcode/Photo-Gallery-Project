<?php
// strftime() will be passed ar argument here.
function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name){
  $class_name = strtolower($class_name);
  // Why is the line below not working ????
   // $path = "../includes/{$class_name}.php";
  $path = "../includes/{$class_name}.php"; // WORKING WHY ???
  if (file_exists ($path)) {
    require_once ($path);
  } else {
    die("File {$class_name}.php cannot be found");
  }
}

function log_action($action, $message=""){
  $logfile = "../../logs/log.txt";

  // Look carefully...
  $new = file_exists($logfile) ? false : true; 

  // Need to clean this code
  //if (file_exists($file) && is_writable($file)) { 
    if ($handle = fopen($logfile, 'a')) { //append - use or create new
      
    $timestamp =  strftime("%Y - %m - %d %H : %M : %S", time());
    $content = "{$timestamp} | {$action} : {$message}\n" ;

    fwrite($handle, $content);
    fclose($handle);

    // In case file does not exist
    if ($new) {chmod ($logfile, 0755); }
    } else {
      echo "File could not be accessed.";
    }     
}

function datetime_to_text($datetime=""){
  $unixtimestamp =  strtotime($datetime);
  return strftime("%B %d %Y at %I:%M:%p", $unixtimestamp);
}