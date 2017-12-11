<!DOCTYPE html>
<html>
<head>
	<title>Activate</title>
	<link rel="stylesheet" type="text/css" href="../css.css">
	<meta http-equiv="refresh" content="2;url=http://dukov.pl/todobeta">
</head>
<body>
	<h1>Your account is active.</h1>
	<h2>Please wait for redirection</h2>
</body>
</html>
<?php
	$userID = $_GET['activate'];
	
	function active($userID){

		try{
			
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("UPDATE users SET apply = 1 WHERE userID='$userID'"); 
			$stmt->execute();

		}
		catch (PDOException $e){
			$e->getMessage();
		}
	}

	if (isset($_GET['activate'])) {
		active($userID);
	}
	else{
		header("Location: ../index.php");
	}