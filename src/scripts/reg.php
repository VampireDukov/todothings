<?php
$checkvalidate;
$checkexist;
$email = $_POST['login'];
$password = $_POST['password'];

function validate($email, $password){


	if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/[a-zA-Z0-9]{6,16}/', $password)) {
    	
		return true;
	} else {
	
    	return false;
    	
	}

}

function signUp($email, $password){

		try {
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			$password = sha1($password);
  			$stmt = $conn->prepare("INSERT INTO users (login, password, apply ) VALUES ( :login, :password, false)"); 
  			
			$stmt->execute(array(':login' => $email,
								':password' => $password));	
			$stmt=$conn->query("SELECT userID FROM users WHERE login='$email' ");
			$conn = null;
			$row = $stmt->fetch();
		
  			sendActivateMail($email,$row['userID']);
  		
  		}
  		catch(PDOException $e)
  	  	{
   	 		$e->getMessage();
			echo "false";
		}	
}
function sendActivateMail($email, $userID){
	ob_start();
	$address = 'ajjambor912@gmail.com'; 	
	$activate = 'http://dukov.pl/todobeta/scripts/activated.php?activate='.$userID;
	
	@$content = "Hello ".$email."\nThanks for usage our site. Please activate your account!\n".$activate;

	$header = 	"From: ".$address." \nContent-Type:".
			' text/plain;charset="iso-8859-2"'.
			"\nContent-Transfer-Encoding: 8bit";
	if (mail($email, 'Message from ToDoThings: ', $content , $header))
		
			echo "true";
	else 
			echo 'false';
			
		
}
function checkExist($email){

	try{	
			$conn = new PDO("mysql:host=sql.dukov.nazwa.pl;dbname=dukov_list", 'dukov_list', '1Kurwa2Kurwa3Kurwa');
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $conn->prepare("SELECT count(*) FROM users WHERE login = :login"); 
			$stmt->execute(array(':login' => $email));
			$row = $stmt->fetch();
			$result = $row[0];
			$conn = null;
			if($result <> 1){
			
				return true;
			
			}
		}
		catch(PDOException $e){
			$e->getMessage();
		}
}
$checkvalidate = validate($email, $password);
$checkexist = checkExist($email);
if ($checkvalidate == true && $checkexist == true){
	signUp($email,$password);
	
}
else{
	echo "false";
}
?>