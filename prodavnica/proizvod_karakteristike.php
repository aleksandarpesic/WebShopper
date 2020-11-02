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
	
	
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Kategorije</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->							
							<?php 
							require_once 'functions.php';
							$result= queryMysql("SELECT `id`, `name` FROM `category`"); 
							$num=$result->num_rows;
							?>
							
							<?php 
							for($j=0; $j<$num;$j++){
								$row=$result->fetch_assoc(); // trenutni slog
										
							?>	
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="proizvodi.php?a=<?php echo $row['id'];?>"> <?php echo $row['name']?> 
									</a></h4>
								</div>
							</div>
								<?php
									}
								?>
					
						</div><!--/category-products-->					
					</div>
				</div>
				<?php
					//queryMysql("SELECT * FROM ad WHERE id=4;SELECT * FROM aca;");
				
				?>
				<?php 						
						if(isset($_GET['a'])){
							if(!is_numeric($_GET['a'])) { die("Error id_product"); }
							$id_product=$_GET['a']; echo "id_product: "; echo $id_product;
						$result= queryMysql("SELECT * FROM ad WHERE id=$id_product");
						$row=$result->fetch_assoc(); //posto je id jedinstven imam samo jedan red
						
							
						}	
							if(isset($_POST['kolicina']) && $_POST['kolicina']!="") {
								$numOfItem=$_POST['kolicina'];								
								
								
								if($loggedIn==FALSE) die("Samo korisnici mogu dodavati u korpu. Molimo registrujte se kao korisnik");
								if($loggedAdmin==TRUE) die("Ti si administrator, ne korisnik, ne mozes da kupujes. Napravi nalog korisnika pa onda poruci.");
								
								$result= queryMysql("SELECT * FROM `ad` WHERE `id`='$id_product' ");
								$row=$result->fetch_assoc(); //posto je id jedinstven imam samo jedan red
								
								$result2= queryMysql("SELECT * FROM `members` WHERE `id`='$id' "); //$id je superglobalna promenljiva
								$row2=$result2->fetch_assoc(); //posto je id jedinstven imam samo jedan red
								$adresa=$row2['adress'];
								$mobilni=$row2['mobile'];
								$imePrezime=$row2['name'];
								$imePrezime.=" ";
								$imePrezime.=$row2['last_name'];
								
								if(!isset ($adresa) ||  $adresa==""  || !isset ($mobilni) ||  $mobilni==""){
									echo "Vasa adresa i kontakt telefon su nam potrebni kako bi smo Vam poslali proizvod.
    			Molimo Vas udjite u Nalog i popunite punu adresu i kontakt telefon, a zatim dodajte ovaj proizvod u korpu.
    			 <br><br><br><br> ";
								}else {
									if (is_numeric($numOfItem) && $numOfItem>0){
									queryMysql("INSERT INTO `cart` (`number_of_item`,`start_date`, `product_id`,`sent`,`user_id`) VALUES (
											'$numOfItem',  NOW() , '$id_product', 'FALSE', '$id' ) ");
									
									$titleAd=$row['title'];
									echo "Zahvaljujemo se na porudzbini proizvoda $titleAd. Proizvod je uspesno dodat u korpu. <br><br>
									Podatke koje cemo smatrati validnim za slanje paketa: <br> <i>
									Ime i Prezime: $imePrezime<br>
									adresa: $adresa <br>
									mobilni: $mobilni <br> </i>
									Ukoliko neki od navedenih podataka nisu tacni molimo vas da na kartici Korpa stornirate narudzbinu, zatim preko kartice Nalog izmenite validnim i porucite ponovo ovaj proizvod.
									<br>Hvala na razumevanju.<br><br>
									Na Kartici Korpa mozete da pratite stanje artikla.";
									}
								}
							}
				?>
				<div class="col-sm-9 padding-right">
				<div id="resultQ"> 
				</div>
					<div class="product-details"><!--product-details-->					
						<div class="col-sm-5">
							<div class="view-product">
								<img src="<?php echo $row['file_path']; ?>" alt="" />								
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">										
										
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<form method="post" action="proizvod_karakteristike.php?a=<?php echo$id_product;?>">
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->							
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2><?php echo $row['title']; ?></h2>
								<p>Web ID: <?php echo $row['id']; ?></p>
								
								<span>
									<span>EUR:  <?php if($row['cost']!=0) echo $row['cost']." EUR"; else echo "kontakt";?></span> 
									 <label>Kolicina:</label>
									<input type="text" name="kolicina" id="kolicina" value="" />
									
									<button type="submit" class="btn btn-fefault cart" id="mem">									
										<i class="fa fa-shopping-cart"></i>
										Dodaj u korpu									
									</button>									
								</span>
								<p><b>Na stanju:</b> Ima </a> </p>								
								<p><b>Url:</b> <a href="http://<?php echo $row['url'];?>"> <?php echo $row['url'];?> </a></p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
						</form>
					</div><!--/product-details-->
					
				
					<p><b>Detaljnije:</b> <br>  <?php echo $row['text'];?> </a></p>
					
					
				</div>
			</div>
		</div>
	</section>
	
	</script>
<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-prodaja</h2>
							<p>departmanu za racunarske nauke</p>
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