<?php
session_start();
$check;
$note = $_POST['todo'];

function addData($note){

	try {
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  			$stmt = $conn->prepare("INSERT INTO notes (login, password, apply ) VALUES ( :login, :password, false)"); 
  			
			$stmt->execute(array(':login' => $email,
								':password' => $password));	
			$stmt=$conn->query("SELECT userID FROM users WHERE login='$email' ");
			$conn = null;
			$row = $stmt->fetch();
			echo $row['userID'];
  			sendActivateMail($email,$row['userID']);
  		
  		}
  		catch(PDOException $e)
  	  	{
   	 		$e->getMessage();
			header("Location: ../index.php?reg=false");
		}	
}
}

function validateData($note){

	if (preg_match('/[a-zA-Z0-9]{6,255}/', $note) {
		return true;
	}
}
$check = validateData($note);
if (isset($_SESSION['log'])){
	if ($check = true) {
		addData($note);
	}
}
else {
		return;
	}	
?>