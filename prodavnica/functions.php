<?php


$dbhost='localhost';
$dbname='eshopper';
$dbusetr='aca';
$dbpass='pmfproject12';
$appname="Eshopper";


$salt1="qm&h*";
$salt2="pg!@";

$connection=new mysqli($dbhost, $dbusetr, $dbpass, $dbname,"3308");
if($connection->connect_error){
	die($connection->connect_error);	
}

function queryMysql($query){
	global $connection;
	$result=$connection->query($query);	
	if(!$result) die($connection->error);
	return $result;
}

function createTable($name, $query){
	queryMysql("CREATE TABLE IF NOT EXISTS $name($query) ");
	echo "Table `$name` created or already exists. <br>";
}

function sanitizeString($var){ //da iz user polja izbaci naredbe za html i mysql
	$var=stripcslashes($var);
	$var=htmlentities($var);
	$var=stripslashes($var);
	global $connection;
	return $connection->real_escape_string($var);
}

function destroySession(){
	$_SESSION=array();
	session_destroy(); //kada vise ne koristimo sesiju	
}
function showProfile($id){
	$result=queryMysql("SELECT * FROM `profiles` WHERE `user_id`=$id ");
	if($result->num_rows){
		$row=$result->fetch_array(MYSQL_ASSOC);
		if(file_exists("$id.jpg")){
			echo "<img src='$id.jpg' style='float:left;'>";
		}
		echo stripslashes($row['text']);
		echo "<br><br>";
	}

}
function showImages($id){
	$result=queryMysql("SELECT * FROM `Images` WHERE `user_id`=$id ");
	
	if($result->num_rows){
		for($j=0;$j<$result->num_rows;$j++){
		$row=$result->fetch_array(MYSQL_ASSOC);
		if(file_exists($row['file_path'])){
			echo "<div> <span>". $row['date_upload'] ."</span> <img src='".$row['file_path']."' class=ispisSlike '> 
					</div>";
			echo "<input type='button' onclick='window.location.href = \"/galery.php?id=".$row['id']." \" ' value='Delete'>";
		}		
		echo "<br><br>";
		}
	}
}
function deleteImage($id){
	$result=queryMysql("SELECT * FROM `Images` WHERE id=$id");
	$row=$result->fetch_assoc();
	unlink($row['file_path']);
	queryMysql("DELETE FROM `Images` WHERE `id`=$id");
}

?>