
<?php
session_start();

require_once 'functions.php';
$userstr=' (Guest)';
if(isset($_SESSION['user'])){
	$id=$_SESSION['id'];
	$user=$_SESSION['user'];
	$loggedIn=TRUE;
	$loggedAdmin=FALSE;
	if($_SESSION['user'] =="admin") $loggedAdmin=TRUE;
	$userstr=" ($user)";	
} else{
	$loggedIn=FALSE;	
	$loggedAdmin=FALSE;
}
?>
<?php if(!$loggedIn && !$loggedAdmin) { //Nije logovan ni admin ni user
?>  
<li><a href="login.php"><i class="fa fa-user"></i> Uloguj se</a></li>
<li><a href="signup.php"><i class="fa fa-star"></i> Prijavi se</a></li>

<?php } else if($loggedIn && !$loggedAdmin) {  //logovan je user
?>
<li><a href="editAccount.php"><i class="fa fa-user"></i> Nalog</a></li>
<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Korpa</a></li>
<li><a href="logout.php"><i class="fa fa-lock"></i> Izloguj se</a></li>
<?php }  else if ($loggedAdmin) {  //logovan je admin
?>
<li><a href="administracion.php"><i class="fa fa-user"></i> Administracija</a></li>
<li><a href="porudzbine.php"><i class="fa fa-user"></i> Porudzbine</a></li>
<li><a href="deleteAd.php"><i class="fa fa-crosshairs"></i> Brisanje artikla</a></li>
<li><a href="deleteUser.php"><i class="fa fa-user"></i> Upravljanje korisnicima</a></li>
<li><a href="logout.php" ><i class="fa fa-lock"></i> Izloguj se</a></li>
<?php }  
?>
