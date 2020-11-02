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
							<a href="index.php"><img src="images/home/logo.png" alt="" /></a>
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
	 
	 <div id="contact-page" class="container">
    	<div class="bg">
	    	  	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Profil</h2>
	    				<div class="status alert alert-success" style="display: none"></div>
	 <?php 

	 $error=" ";
	
	if($loggedIn == FALSE) die("Samo korisnik moze pristupiti ovoj stranici");
	
		

		$result= queryMysql("SELECT * FROM `members` WHERE `id`='$id' ");
		$row=$result->fetch_assoc(); //posto je id jedinstven imam samo jedan red
					
					
		if ( isset($_POST['passE'])) {
			$passT=$_POST['passE'];
			$hpass=hash('ripemd128', "$salt1$passT$salt2"); 
			$result=mysqli_query($connection,"select getUser('$user','$hpass')");
			$res=mysqli_fetch_row($result);
				if($res[0] == false){		
				$error="Morate uneti korektnu trenutnu lozinku.";
				}	
			else{
				$nameE=$_POST['nameE'];
				$last_nameE=$_POST['last_nameE'];
				$emailE=$_POST['emailE'];
				$adressE=$_POST['adressE'];
				$mobileE=$_POST['mobileE'];
				
				//ukoliko je izmenio neki od podataka: ime, prezime, email, adresu ili mobilni
				if($row['name']!='$nameE' || $row['last_name']!='$last_nameE' || $row['email']!='$emailE' || $row['adress']!='$adressE' || $row['mobile']!='$mobileE') { 	
				
					if($user!=$emailE){ //ako menja i email adresu ispitujem da li korisnik sa novo zeljenom email adresom vec ne postoji
						$result=mysqli_query($connection,"select userExists('$emailE')"); 
						$res=mysqli_fetch_row($result);
						if($res[0] == false){ 
							queryMysql("UPDATE `members` 
							SET `name`='$nameE', `last_name`='$last_nameE', `email`='$emailE', `adress`='$adressE', `mobile`='$mobileE'
							WHERE `id`='$id' ");
							$error="Podaci uspesno izmenjeni"; 
						} else { 
							$error="Neuspesno. Korisnik sa email adresom $emailE vec postoji"; 
						}
					} else{ //samo azuriram ostale podatke (bez email i lozinke)
						queryMysql("UPDATE `members` 
							SET `name`='$nameE', `last_name`='$last_nameE', `adress`='$adressE', `mobile`='$mobileE'
							WHERE `id`='$id' ");
							$error="Podaci uspesno izmenjeni"; 
					}					
				} 
				 
				 if( ( isset($_POST['newpassE']) && $_POST['newpassE']!="") || (isset($_POST['newpassE2']) && $_POST['newpassE2']!="") ){ // ako menja lozinku				 			
					$newpassT=$_POST['newpassE']; $newpassT2=$_POST['newpassE2'];
					if($newpassT!=$newpassT2) $error="nove lozinke se ne podudaraju";
					else {
						$newPass=hash('ripemd128', "$salt1$newpassT$salt2");
						queryMysql("call changePass('$user','$newPass')");
						$error="Podaci uspesno izmenjeni i lozinka"; 
						//	$error=$newpassT;
						}									
				}
				
			}
			
		}
	?>
	 	
	 			
	    <form method="post" action="editAccount.php" enctype="multipart/form-data" id="main-contact-form" class="contact-form row">
	    	<?php  echo $error; ?>
			<h3>Izmeni podatke</h3> <br>
			
				<div class="form-group col-md-6"> 
				
				             Ime:  <input type="text" name="nameE" class="form-control"  value="<?php echo $row['name']; ?>">
				            </div> 
				            <div class="form-group col-md-6">
				              Prezime:  <input type="text" name="last_nameE" class="form-control"  value="<?php echo $row['last_name']; ?>">
				            </div>
				           
				            <div class="form-group col-md-6">
				               Email: <input type="text" name="emailE" class="form-control"  value="<?php echo $row['email']; ?>">
				            </div>
				            
				            <div class="form-group col-md-6">  (*)	
				               Puna adresa: <input type="text" name="adressE" class="form-control"  value="<?php echo $row['adress']; ?>">
				            </div> 
				            
				            <div class="form-group col-md-6">  (*)
				               Telefon: <input type="text" name="mobileE" class="form-control"  value="<?php echo $row['mobile']; ?>">
				            </div>
				            
				             <div class="form-group col-md-6">
				               Lozinka: <input type="password" name="passE" class="form-control" >				              
				            </div>
			
			<div class="form-group col-md-6">
				               Nova lozinka: <input type="password" name="newpassE" class="form-control" >	(opciono polje)			              
				            </div>
			 <div class="form-group col-md-6">
				               Ponovite novu lozinku: <input type="password" name="newpassE2" class="form-control" >				              
			</div>
			<input type="submit" value="Zapamti izmene">
	</form>
				    	<br><br><br><br>
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center"></h2>
	    				 
	    				<div class="social-networks">
	    					<h2 class="title text-center">Moguce kategorije</h2>
							<ul>
							<?php 
							
							
							?>
							
							
	    				</div>
	    			</div>
    			</div>    			
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->
	
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