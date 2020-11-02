<!DOCTYPE html>
<html lang="en">
<head>	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ove mozete pronaci i naruciti razne proizvode iz vise mogucih kategorija.">    
    <title>PMF Projekat</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">								
								<li><a href="#"><i class="fa fa-envelope"></i> aleksandar.pesic3@pmf.edu.rs</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="images/home/logo.png" alt="" /></a>
						</div>
					
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
						<ul class="nav navbar-nav">
							<?php
							require_once 'header.php'; ?>
						</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
					<?php
							require_once 'meni.php'; ?>
					
						
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Search"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<?php 
$ipaddress = '';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];    
}
?>
	
	<?php

$user=$pass=$error='';
if(isset($_POST['user'])){
	$user=sanitizeString($_POST['user']);
	
	if($user == '' ){
		$error="Unesi potrebne podatke <br>";
	}
		else{
			$huser=hash('ripemd128', "$salt1$user$salt2");
			$result=queryMysql("SELECT * FROM `members` WHERE `email`='$user'");
			if($result->num_rows == 0){
				$error="<span class='error'>Korisnik ne postoji</span><br><br>";				
			}
			else {			
				$message="
    		Postovani, 
    		
    		Klikon na link mozete promeniti lozinku: http://www.srebrnavoda.biz/Ekupovina/resetPass2.php?a=".$huser."
    		
    		Ukoliko niste zatrazili novu lozinku jednoistavno ignorisite ovaj email.
    		
    		Pozdrav";
				
				mail($user,"Zahtev za promenom lozinke",$message);
				$error="Uredu, zahtev je poslat na Vasu email adresu. Proverite svoju email adresu, kao i folder spam (nezeljenu postu).";
				}
			}
	}

?>


	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
			<?php echo "$error" ?>
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Da bi ste promenili lozinku unesite validnu email adresu sa kojom ste registrovani</h2>
						<form method="post" action="resetPass1.php">
						
							<input type="text" name="user" id="user" placeholder="Email" />
							
														
							<button type="submit" class="btn btn-default">Zatrazi</button>
						</form>
					</div><!--/login form-->
				</div>
				
				<div class="col-sm-4">					
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	
	<<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Uloguj se</h2>
						<form method="post" action="login.php">
						<?php echo "$error" ?>
							<input type="text" name="user" id="user" placeholder="Email" />
							<input type="password" name="pass" id="pass" placeholder="Lozinka" />
							<a href="resetPass1.php"> Zaboravljena lozinka</a>							
							<button type="submit" class="btn btn-default">Prijavi se</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<?php
					include 'signup.php'; 
				?>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Napravi nov nalog!</h2>
						<form method="post" action="signup.php">
						<?php echo "$errorR" ?>
							<input type="text" name="nameR" id="nameR" placeholder="Ime"/>
							<input type="text" name="surnameR" id="surnameR" placeholder="Prezime"/>
							<input type="email" name="userR" id="userR" placeholder="Email"/>
							<input type="password" name="passR" id="passR" maxlength="16" placeholder="Lozinka"/>
							<br>
							<button type="submit" class="btn btn-default">Registruj se</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-prodaja</h2>
							<p>departman za racunarske nauke</p>
							<?php  $result=mysqli_query($connection,"select getOnline()");
									$res=mysqli_fetch_row($result);	 echo "Broj online korisnika: ".$res[0]; ?>
						</div>
					</div>
					<div class="col-sm-7">		

					</div>
					
					<div class="col-sm-3">					
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>Serbia Products</p>
						</div>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2020  All rights reserved.</p>					
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>