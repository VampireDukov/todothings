<?php
session_start();

$note = $_POST['todo'];
$temp = $_POST['temporary'];
$check;

function validateData($note){
	
	if (!empty($note)) {
		return true;
	}
	else
		return false;
}

function addData($note,$temp){

	try {
			$userID = $_SESSION['log'];
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$stmt = $conn->prepare("UPDATE notes SET noteText = :note WHERE noteText='$temp'"); 
  				
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

$validate = validateData($note);

if ($validate == true &&  $check == true) {

	addData($note,$temp);

}
else{
	return;
}