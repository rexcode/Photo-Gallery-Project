<?php  

require_once 'initialize.php';

class Photograph extends DatabaseObject
{
	protected static $table_name = "photographs";
	protected static $db_fields = array('id', 'filename', 'type', 'size', 'caption', 'uploader');
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;
	public $uploader;

	private $temp_path;
	public $upload_dir = "images";
	public $errors = array();

// In an application, this could be moved to a config file
	//This is an array so, we can pick elements out of it..
	
protected $upload_errors = array(
	// We can add our own errors as well..
	// http://www.php.net/manual/en/features.file-upload.errors.php
	//This are predefined constants..

	UPLOAD_ERR_OK 				=> "No errors.",
	UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
  UPLOAD_ERR_NO_FILE 		=> "No file.",
  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
);

// Pass $_FILES['file_upload'] as an argument.

public function image_path(){
	return $this->upload_dir."/".$this->filename;
	//$target_path = "../".$upload_dir."/".$this->filename;
}

public function attach_file($file){
	// perform error checking on form params(parameters)..
	// Set object attributes to the form parameters	
	// means we will ise use if() -- if no error set the file params as object attributes.
	// We instantiate a file ready to be saved
	if (!$file || empty($file) || !is_array($file)) {
		// check if the file is set / empty or not..
		$this->errors[] = "No file was uploaded.";
		return false;
	
	} elseif ($file['error'] != 0) {
		// check for ant uploading errors..
		$this->errors[] = $this->uploaded_errors[$file['error']];
		return false;

	} else {
		//Set the object parameters to the received / uploaded file
		// basename() will result only in a filename with it's extension
		$this->filename = basename($file['name']);
		$this->type = $file['type'];
		$this->size = $file['size'];
		$this->temp_path = $file['tmp_name'];
	  // echo "file attach ok.. <br>";
		return true;
	}
}

public function save(){
	// A new record won't have an id yet.
	if (isset($this->id)) {
	// We r just updating the caption..	
		$this->update();
	} else {
		// make sure there r no errors...
		
		//	 Check for errors from uploading
		if (!empty($this->errors)) {	
			// echo "file save not ok..";
			// print_r($this->errors);
		  return false; }

		// check whether caption is within limit
		if (strlen($this->caption) > 255) {
			$this->errors[] = "The caption length is greater than 255 characters.";
			return false;
		}

		// Check is file and temp file location exists ?
		if (empty($this->filename) || empty($this->temp_path)) {
			$this->errors[] = "The file location does not exist.";
			// echo "file location does not exist..";
			return false;
		}

		// Determine the target path	- 3 ways -
		//$target_path = "../images/".$this->filename;
		//$target_path = "../".$upload_dir."/".$this->filename;
		$target_path = "../".$this->image_path();

		// Check if the file already exists in the target location..
		if (file_exists($target_path)) {
			$this->errors[] = "The file {$this->filename} already exists.";
			// remember this echo below will appear above the adming_header.php
			// echo "<br> file  already exists";
			return false;
		}

		// Attempt to move the file
		if (move_uploaded_file($this->temp_path, $target_path)) {
			// Successs - save a corresponding entry in the database.
			if ($this->create()) {
				//
				unset($this->temp_path);
				// echo "<br>file created";
				return true;
			}
		} else {
			// file was not moved
			$this->errors[] = "This file upload failed, possbily due to incorrect upload folder persmissions.";
			// echo "file not uploaded ...";
			return false;
		}

	}
}

public function size_as_text(){
	if ($this->size <= 1024) {
		return $this->size ."Bytes";
	} elseif ($this->size < 1048576) {
		return round($this->size / 1024)."KB";
	} else {
		return (round(($this->size / 1048576), 1))."MB";
	}
}

public function destroy(){
	// delete the database entry
	// remove the file
	if ($this->delete()) {
	//  $target_path = "../".$this->upload_dir."/".$this->filename;
	// $target_path = "../images/".$this->filename;
  		$target_path = "../".$this->image_path();
  		return unlink($target_path) ? true : false;
	} else {
		return false;
	}

}


public function comments(){
	// Be careful an spelling mistakes....
	     //WRONG -- Comments::find_comments_on($photo->id)
	return Comment::find_comments_on($this->id);
}

// COMMON DATABASE METHODS
	public static function find_all(){
		// global $db; // import dataase object from database class
		$sql = 'SELECT * FROM '.self::$table_name;
		//$result_set = $db->query($sql);
		//returns $object_array with only all rowas as objects
		return self::find_by_sql($sql);
		//return $result_set;
	}

			public static function find_by_id($id=0){
		global $db;
		$sql = "SELECT * FROM ". self::$table_name . " WHERE id = {$db->escape_value($id)} LIMIT 1";
		//$result_set = $db->query($sql);
		$result_array = self::find_by_sql($sql);// returns $object_array with only 1 object
		// Here only 1 record returned
		//$record = $db->fetch_assoc($result_set);
		// return $record;
		// array_shift removes the first element (here object) out of the array and returns it.
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function find_by_sql($sql=""){
		global $database;
		$result_set = $database->query($sql);
		// return $result_set; // is a table - a resource...
		$object_array = array();
		// $row refers to a one user / entry from the users table...
		while ($row = $database->fetch_assoc($result_set)) {
			// converting each row / entry from table 
			// into an object which is stored in $object_array
			$object_array[] = self::instantiate($row);
		}
		return $object_array;

	}

	// Count the no. of records in the given table.
	public static function count_all(){
		global $database;
		$sql = "SELECT count(*) FROM ".self::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_assoc($result_set);
		return array_shift($row);
	}

	// instantiate() converts a static table row -- an assoc .array with attributes --
	// into a object attributes.
	public static function instantiate($record) {
		// Check if $record exists and is an array
		// $object = new User();
		// $object = new self;
		$object = new Photograph();
		// Short Method
		foreach ($record as $attribute => $value) {
			// Why check ???
			if ($object->has_attribute($attribute)) {
				// See the syntax of attribute here with $ - dynamic variable
				$object->$attribute = $value;
			}
		// return $object;	-- ThIS IS WRONG WRONG
		}
		//BE VERY VERY CAREUL WHERE U R RETURNING YOUR OBJECT
		// HERE I LOST 1 HOUR BCOZ OF THAT MISTAKE
		return $object;

		// Long method
		// not required here ---> $record = User::find_by_id(1);
		// $object->username = $record['username'];
		// $object->password = $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name = $record['last_name'];
		// $object->id = $record['id'];
	}

	public function has_attribute($attribute){
		// get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
		$object_vars = $this->attributes();
		// We don't care about the value, we just want to know if the key from the row/entry exists in the object..
	  // Will return true or false
		return array_key_exists($attribute, $object_vars);
	}

public function attributes(){
	// returns an assoc. array with attributes and their values of $this object.
	//return get_object_vars($this);

	//Second method
	$attributes = array();
	// return an array of attribute names and their values
	// which r in the obect and also have DB fields.
	foreach (self::$db_fields as $field) {
		if (property_exists($this, $field)) {
	// will assign the value of this object field attribute to the
	// $attributes array
		$attributes[$field] = $this->$field;
		}
	}
	return $attributes;	// Be careful while returning here....
}

// escaping the values before sending them to sql/db.
public function sanitized_attributes(){
	global $database;
	//$attributes = $this->attributes();
	$clean_attributes = array();
	foreach ($this->attributes() as $key => $value) {
		$clean_attributes[$key] = $database->escape_value($value);
		//return $clean_attributes; //WRONG WRONG WRONG
	}
	return $clean_attributes; // THis is a right way.
}

// public function

// replaced with a new custom save()

// public function save(){
// 	return ($this->id) ? $this->update() : $this->create();
// }

protected function create(){
	global $database;
	$attributes = $this->sanitized_attributes();

	$sql  = "INSERT INTO ".self::$table_name." ( ";
	// join the attribute array into a  string
	$sql .= join(", ", array_keys($attributes));
	// $sql .= " username, password, first_name, last_name )";
	$sql .= " ) VALUES ( '";
	$sql .= join("', '",array_values($attributes));	//, and space are not applied
	// at the end of last item in the array while joining them.
	$sql .= "')";
	//Long method
	// $sql .= $database->escape_value($this->username). "', '";
	// $sql .= $database->escape_value($this->password). "', '";
	// $sql .= $database->escape_value($this->first_name). "', '";
	// $sql .= $database->escape_value($this->last_name). "') ";

 if($database->query($sql)){ //will return a true or false as this is an insert query...
 	// get the last id inserted into the DB
			$this->id = $database->insert_id();
			return true;
	} else {
			return false;
	}
}

protected function update(){
	global $database;
	$attributes = $this->sanitized_attributes();
	$attribute_pairs = array();
	foreach ($attributes as $key => $value) {
		$attribute_pairs[] = "$key = '$value'";
	}

	$sql = "UPDATE ".self::$table_name." SET ";
	$sql .= join(", ", $attribute_pairs); //, and space are not applied
	// at the end of last item in the array while joining them.
	// Long method
	// $sql .= " username= '".$database->escape_value($this->username)."', ";
	// $sql .= " password= '".$database->escape_value($this->password)."', ";
	// $sql .= " first_name= '".$database->escape_value($this->first_name)."', ";
	// $sql .= " last_name= '".$database->escape_value($this->last_name)."' ";
	$sql .= " WHERE id = ". $database->escape_value($this->id) ;

	$database->query($sql); //will return a true or false as this is an update query...
	return ($database->affected_rows() == 1) ? true : false;
}

public function delete(){
	global $database;
	$sql = "DELETE FROM ".self::$table_name;
	$sql .= " WHERE id = ". $database->escape_value($this->id);
	$sql .= " LIMIT 1";

	$database->query($sql);//will return a true or false as this is a delete query...
	return ($database->affected_rows() == 1) ? true : false ;
}	






}

?>