<?php  

// defined('DS') ? null : define("DS", DIRECTORY_SEPARATOR);
//load config file first
require_once 'config.php';

// load functions so that everything after can use them
require_once 'functions.php';

// load core objects
require_once 'session.php';
require_once 'database.php';
require_once 'database_object.php';
require_once 'pagination.php';
// require_once 'logger.php';

//load database-related classes
require_once 'user.php';
require_once 'photograph.php';
require_once 'comment.php';