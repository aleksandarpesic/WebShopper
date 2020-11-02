<!DOCTYPE html">
<html>
<head>
	<title> Setting up database </title>
</head>

<body>
	<h3>Setting up...</h3>
	
	<?php
		require_once 'functions.php';
		
		/*
		include functions.php; //trazi php fail ako ne postoji ne pravi probleme
		include_once 'functions.php'; //isto kao include samo pita da li je vec ukljucen.
		require 'functions.php'; //ako ga ne nadje prekida izvrsenje
		*/
		
		
		$result=queryMysql("SELECT * FROM `members` WHERE `email`='admin'");
		if(! $result->num_rows){
		$pass="pmfproject12";
		$hpassR=hash('ripemd128', "$salt1$pass$salt2");
		queryMysql("call add_admin('admin','$hpassR')");
		}
		
		
	?>
	
</body>
</html>



