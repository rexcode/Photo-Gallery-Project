<?php  
// From Stackoverflow
// If you don't return anything, just use return; or omit it at all at the end of the function.
// If your function is usually returns something but doesn't for some reason, return null; is the way to go.

// That's similar to how you do it e.g. in C: If your function doesn't return things, it's void, otherwise it often return either a valid pointer or NULL

// Database Constants
// REURN null means nothing
defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost'); 
defined('DB_USER') 	 ? null : define('DB_USER', 'gallery'); 
defined('DB_PASS')   ? null : define('DB_PASS', 'photo'); 
defined('DB_NAME')  or define('DB_NAME', 'photo_gallery'); 

// defined('DB_SERVER') ? null : define('DB_SERVER', 'mysql.hostinger.in'); 
// defined('DB_USER') 	 ? null : define('DB_USER', 'u140634069_admin'); 
// defined('DB_PASS')   ? null : define('DB_PASS', 'photogallery'); 
// defined('DB_NAME')  or define('DB_NAME', 'u140634069_photo'); 

// Alternate way
// defined('CONSTANT') or define('CONSTANT', 'SomeDefaultValue');

// nothing just testing
// defined('check') 
// { return null; }
?>