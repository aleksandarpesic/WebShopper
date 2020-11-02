<?php
	
	require_once 'login.php';
	$nameR=$surnameR=$userR=$passR=$errorR='';
	
	if(isset($_POST['userR'])) {
		$nameR=sanitizeString($_POST['nameR']);
		$surnameR=sanitizeString($_POST['surnameR']);
		$userR=sanitizeString($_POST['userR']);
		$passR=sanitizeString($_POST['passR']); // indeks= name atributu iz indexa
		if($userR=='' || $passR=='' || $nameR=='' || $surnameR=='' ){
			$errorR="Popunite sva polja<br><br>";
		}
		else{
			$result=queryMysql("SELECT * FROM `members` WHERE `email`='$userR'");
			if($result->num_rows){
				$errorR="Ova Email adresa je zauzeta";
			} else{
				/*var_dump($user);
				var_dump($pass);
				die();*/
				$hpassR=hash('ripemd128', "$salt1$passR$salt2");
				queryMysql("call add_user('$nameR','$surnameR','$userR','$hpassR')");
				die("<h4>Account created</h4>Please log on.");
			}
		}
	}
?>

