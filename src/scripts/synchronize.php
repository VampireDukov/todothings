<?php
	session_start();
	$array = $_POST['list'];
	$userID = $_SESSION['log'];
	$result = null;
	

	function getData($userID, $array){


		try{
			
			
			$stmt;
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->query("SELECT noteText FROM notes WHERE userID='$userID'");

			$row = $stmt->fetchAll();
		
			
			
			
			foreach ($array as $note) {
				
				$comp = $conn->query("SELECT count(*) FROM notes WHERE noteText='$note' AND userID='$userID'");
				$result = $comp->fetch();
				if ($result[0] == 0 ) {
			
					$stmt = $conn->prepare("INSERT INTO notes (noteText, userID) VALUES (:note, :userID)");
					$stmt->execute(array(':note' => $note,
									':userID' => $userID));	
					
				}
				
				
			}
			header('Content-Type: application/json');
			echo json_encode($row);
			
			$conn = null;
			
			
		}	
		catch(PDOException $e)
		{
			
			$e->getMessage();
			return false;
   		}	
	}
	



	getData($userID,$array);

?>