<?php  
require_once 'database.php';

class Comment extends DatabaseObject{

protected static $table_name = "comments";
protected static $db_fields = array('id', 'photograph_id', 'created', 'author', 'body');

public $id;
public $photograph_id;
public $created;
public $author;
public $body;

// new is a reserved keyword... use make or build etc..
// instantiate a comment object based upon user input..
// like a factory or constructor that instantiates a comment for us..

public static function make($photo_id, $author="Anonymous", $body){
	if (!empty($photo_id) && !empty($body)) { // comment id is auto incremented.
		$comment = new Comment();
		$comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
		$comment->author = $author;
		$comment->photograph_id = (int)$photo_id;
		$comment->body = $body;
		return $comment;
	} else {
		return false;
	}
}

public static function find_comments_on($photo_id=0){
	global $database;
	$sql  = "SELECT * FROM ". self::$table_name;
	$sql .= " WHERE photograph_id = ". $database->escape_value($photo_id);
	$sql .= " ORDER BY created ASC";
	return self::find_by_sql($sql);
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
		$object = new Comment();
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
		$object_vars = $this->attributes(); // is an array now
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
public function save(){
	return ($this->id) ? $this->update() : $this->create();
}

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
 	// get the last id inserted into the DB and assign it to this object's id attribute.
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