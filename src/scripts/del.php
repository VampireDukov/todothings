<?php
	session_start();
	
	$userID = $_SESSION['log'];

	function deleteUser($userID){
		try {
			
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$stmt = $conn->exec("DELETE FROM users WHERE userID = '$userID'"); 
  			

			$conn = null;
			
  			
  		}
  		catch(PDOException $e)
  	  	{
   	 		$e->getMessage();
			
			return;
		}
	}

	function deleteData($userID)
	{
		try {
			
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$stmt = $conn->exec("DELETE FROM notes WHERE userID = '$userID'"); 
  			

			$conn = null;
			deleteUser($userID);
  			
  		}
  		catch(PDOException $e)
  	  	{
   	 		$e->getMessage();
			
			return;
		}
	}
	
	session_start();
	if(!isset($_SESSION['log'])){
		header("Location: ../index.php?login=notlogon");

		
	}
	else{
		deleteData($userID);
		session_destroy();
	
		header("Location: ../index.php?login=deluser");
	}

?>	
	