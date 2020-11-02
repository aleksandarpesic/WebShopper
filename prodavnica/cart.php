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

	<?php 
	
	if(isset($_GET['a'])){
		$ida=$_GET['a'];
		
		queryMysql("DELETE FROM `cart` WHERE `id`='$ida' ");
		
	}


	?>
	<section id="cart_items">
		<div class="container">
			
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Proizvod</td>
							<td class="description">Naslov</td>
							<td class="price">Cena</td>							
							<td class="total">Datum</td>
							<td class="total">Izbaci iz korpe</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php
					
					if($loggedIn == FALSE) die("Samo korisnici mogu stavljati u korpu");
					
						$result= queryMysql("SELECT * FROM `cart` WHERE `user_id`='$id' ORDER BY id DESC  "); 
						$num=$result->num_rows;	
						
					?>
							<?php 
							for($j=0; $j<$num;$j++){
								$row=$result->fetch_assoc(); // trenutni slog	
								$prom=$row['product_id'];
								$result2= queryMysql("SELECT * FROM `ad` WHERE `id`='$prom' ");
								$row2=$result2->fetch_assoc();
							?>
							
						<tr>
							<td class="cart_product">
								<a href="proizvod_karakteristike.php?a=<?php echo $row2['id'];?>"><img src="<?php echo $row2['file_path']; ?>" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="proizvod_karakteristike.php?a=<?php echo $row2['id'];?>"><?php echo $row2['title']; ?></a></h4>
								<p>Web ID: <?php echo $row2['id']; ?></p>
								<p>kolicina: <?php echo $row['number_of_item']; ?></p>
								<p><?php if($row['sent']!=0) echo "Stanje slanja: poslato"; else echo "Stanje slanja: u pripremi"; ?> </p>
							</td>
							<td class="cart_price">
								<p><?php if($row2['cost']!=0) { 
									$totalPrice=$row2['cost']*$row['number_of_item'];
									echo $totalPrice." EUR"; 
									
								}else echo "kontakt EUR"; ?></p>
							</td>
							
							<td class="cart_total">
								<p class="cart_total_price"><?php echo $row['start_date'];?></p>
							</td>
							
							<td class="cart_delete">
							<?php 
							if($row['sent']==0) //ako je proizvod poslat ne moze da odustane od kupovine
								echo "<a class='cart_quantity_delete' href='cart.php?a=".$row['id']."'><i class='fa fa-times'></i></a>";
							?>
							</td>
						</tr>
					<?php 
							}										
						?>
						
						
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	


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