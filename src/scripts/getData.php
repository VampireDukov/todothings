<?php

$userID = $_SESSION['log'];

function getData($userID){

	try{

			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$stmt = $conn->exec("SELECT FROM notes WHERE  userID= '$userID'" );
			$row = $stmt->fetchAll();

			foreach ($row as $line) {
			 	
			 	echo "<li><span class='cell'>".$line."</span><img src='X.png' class='cell del'></li>";
			 } 
  			

			$conn = null;	
	}
	catch(PDOException $e){

		$e -> getMessage();
		return false;
	}
}

getData($userID);