<?php
	session_start();
	$note = $_POST['del'];
	$userID = $_SESSION['log'];
	
	function deleteData($note, $userID)
	{
		try {
			
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$stmt = $conn->exec("DELETE FROM notes WHERE  userID= '$userID' AND noteText = '$note'" ); 
  			

			$conn = null;
		
  			
  		}
  		catch(PDOException $e)
  	  	{
   	 		$e->getMessage();
			
			return;
		}
	}
	deleteData($note,$userID);
?>	
	