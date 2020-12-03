<?php
// Class that implemnt CRUB for JSON file as a mock DB

class CRUDJson {

	public $db = "db.json";
	/// setDocument
	// SET - ADD NEW DOC
	function setDocument(String $noteId, String $userId, String $description) {
	    $jsonString = file_get_contents("db.json"); 
	  	$data = (array)json_decode($jsonString, true);
		$newData = array(
			"noteId"      => $noteId,
			"userId"    => $userId,
			"description" => $description
		);
		array_push($data,$newData);
		$json = json_encode($data, JSON_PRETTY_PRINT);

		if (file_put_contents("db.json",$json)) {
			$json_note = json_encode($newData, JSON_PRETTY_PRINT);
			return $json_note;
			//echo "Success add Data on JSON..";
		}else{
			//echo "Failed add Data on JSON..";
			return NULL;
		}
	}
	// GET - get document by noteId
	function getDocument(String $documentID) {
		$jsonString = file_get_contents("db.json"); 
		$data = (array)json_decode($jsonString, true);
		foreach ($data as $key => $val) {
			if (strcmp($val["noteId"],$documentID) == 0) {
				$json = json_encode($val, JSON_PRETTY_PRINT);
	  			return  $json;
			}
		}
	}
	//GET - Get all notes from JSON FILE
	function getAll() {
		$jsonString = file_get_contents("db.json"); 
		$data = (array)json_decode($jsonString, true);
		$json = json_encode($data, JSON_PRETTY_PRINT);
		return $json;
	}
	// UPDATE - Update content of note by note ID
	function updateDocument(String $documentID, String $newDescription) {
		$jsonString = file_get_contents("db.json"); 
		$data = (array)json_decode($jsonString, true);
		$current = NULL;
		foreach ($data as $key => $value) {
			if (strcmp($value["noteId"],$documentID)==0) {
				$data[$key]["description"] = $newDescription;
				$current = $data[$key];
			}
		}
		$json = json_encode($data, JSON_PRETTY_PRINT);
		$current_json = json_encode($current, JSON_PRETTY_PRINT);
		if(file_put_contents("db.json", $json)) 
		{
			return  $current_json;
		} else {
			return NULL;
		}
	}
	// DELETE - Delete note by note ID
	function deleteDocument(String $documentID) {
	  $jsonString = file_get_contents("db.json"); 
	  $data = (array)json_decode($jsonString, true);
	  $arr_index = array();
	  foreach ($data as $key => $value) {
		 if (strcmp($value['noteId'],$documentID) == 0) {
		    	$arr_index[] = $key;
		 }
	   }
	  foreach ($arr_index as $key) {
		  unset($data[$key]);
	  }
	  $json_arr = array_values($data);
	  $json = json_encode($json_arr, JSON_PRETTY_PRINT);
	  if(file_put_contents("db.json", $json)) 
		{
			return  $json;
		}else{
			return NULL;
		}
	}

} 

?>
