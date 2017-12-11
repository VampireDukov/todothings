<?php
$checkvalidate;
$checkexist;
$email = $_POST['login'];
$password = sha1($_POST['password']);

session_start();

function validate($email, $password){


	if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/[a-zA-Z0-9]{6,16}/', $password)) {
    	
		return true;
	} else {
		
    	return false;
    	
	}

}

function login($email, $password){

	try{	
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT count(*) FROM users WHERE login = :login AND password =:password"); 
			$stmt->execute(array(':login' => $email,
								':password' => $password));
			$row = $stmt->fetch();
			$result = $row[0];
			
			$stmt = $conn->prepare("SELECT userID FROM users WHERE login = :login AND password =:password"); 
			$stmt->execute(array(':login' => $email,
								':password' => $password));
			$id = $stmt->fetch();
		
			$id=$id['userID'];

			$conn = null;

			if($result <> 1){
			
				return;
			
			}
			else
			{
				
				$_SESSION['log'] = $id;
				echo 'true';
			}
		}
		catch(PDOException $e){
			$e->getMessage();
		}

}
function isActive($email){
	try{	
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT count(*) FROM users WHERE login = :login AND apply =1"); 
			$stmt->execute(array(':login' => $email));
			$row = $stmt->fetch();
			$result = $row[0];
		

			$conn = null;

			if($result == 1){
			
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
$active = isActive($email);
$checkvalidate = validate($email, $password);
if ($checkvalidate == true && $active == true) {
	login($email,$password);
}
?>