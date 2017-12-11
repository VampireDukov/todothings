<?php
	session_start();
	if(!isset($_SESSION['log'])){
		header("Location: ../index.php?login=notlogon");

		
	}
	else{
		
		session_destroy();
	
		header("Location: ../index.php?login=logout");
	}
?>	