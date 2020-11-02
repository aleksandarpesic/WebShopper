<?php
require_once 'header.php';
if(isset($_SESSION['user'])){
	queryMysql("update members set online=false where id=$id ");
	destroySession();
	echo "<div class='main'> Uspesno ste se izlogovvali. Kliknite ".
			"<a href='index.php'>ovde</a> ".
			"da osvezite stranicu.";
}
else{
	echo "<div class='main'>Ne mozes da se izlogujes jer nisi ni ulogovan.";	
}
?>
<br><br></div>
</body>
</html>