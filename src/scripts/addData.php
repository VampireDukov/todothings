<?php
session_start();

$note = $_POST['todo'];
$check;
function validateData($note){
	
	if (!empty($note)) {
		return true;
	}
	else
		return false;
}
function isExist($note){
	try{	
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT count(*) FROM notes WHERE noteText = :note"); 
			$stmt->execute(array(':note' => $note));
			$row = $stmt->fetch();
			$result = $row[0];

			
		
			if($result <> 1){
			
				return true;
			
			}
			else
			{
				return false;
			}
		}
		catch(PDOException $e){
			$e->getMessage();
			
		}	
}
function addData($note){

	try {
			$userID = $_SESSION['log'];
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$stmt = $conn->prepare("INSERT INTO notes (noteText, userID) VALUES ( :note, '$userID')"); 
  			
			$stmt->execute(array(':note' => $note));	
			$conn = null;
			
  		
  		}
  		catch(PDOException $e)
  	  	{
   	 		$e->getMessage();

		
		}
}
if (isset($_SESSION['log'])) {
	$check = true;
}
$exist = isExist($note);
$validate = validateData($note);

if ($validate == true && $exist == true && check == true) {

	addData($note);

}
else{
	return;
}