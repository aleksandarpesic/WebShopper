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
						<h2>Moguce kategorije</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->		
						<?php 
							require_once 'functions.php';
							$result= queryMysql("SELECT DISTINCT `category_id` FROM `place_cat`"); 
							$num=$result->num_rows;
						?>
							<?php 
							for($j=0; $j<$num;$j++){
								$row=$result->fetch_assoc(); // trenutni slog								
								$result2= queryMysql("SELECT `name` FROM `category` where id=$row[category_id]");
								$row2=$result2->fetch_assoc();	
								
								$result3= queryMysql("SELECT `sub_category_id`, `id` FROM `place_cat` where category_id=$row[category_id]");
								$num_sum_cat=$result3->num_rows;
							?>	
						<div class="panel panel-default">
						
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											<?php echo $row2['name'] ?> 
										</a>
									</h4>
								</div>
								
									<div class="panel-body">
										<ul>
								<?php 
							for($j2=0; $j2<$num_sum_cat;$j2++){
								$row3=$result3->fetch_assoc();	
								$result4= queryMysql("SELECT `name` FROM `sub_category` where id=$row3[sub_category_id]");
								$row4=$result4->fetch_assoc();
								?>
								
											<li>
											<a href="index.php?a=<?php echo $row3['id'];?>">
											<?php echo $row4['name']; ?> </a>
											</li>
											
										
								<?php
									}
								?>
								</ul>
									</div>
								
							</div>	
								
							<?php
									}
							?>
						
							
							
							
							
								
													
						</div><!--/category-products-->
						
						
					
																	
						
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right"> 
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Proizvodi</h2>
						
						<?php
						if(!isset($_GET['a']) )	{						
						$result= queryMysql("SELECT * FROM `ad` "); 
						$num=$result->num_rows;
						} else{
							$ida=$_GET['a'];
							$result= queryMysql("SELECT * FROM `ad` WHERE place_category_id=$ida ");
							$num=$result->num_rows;
						}
							
							for($j=0; $j<$num;$j++){
								$row=$result->fetch_assoc(); // trenutni slog										
							?>
							
								
								<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
										
											<img src="<?php echo $row['file_path']; ?>" alt="" />
											<h5 style="color:#FE980F"> <?php if($row['cost']!=0) echo $row['cost']." EUR"; else echo "kontakt EUR";?></h5>
											<h4 > <a href="<?php echo $row['title']; ?>"> <?php echo $row['title']; ?> </a> </h4> 
											<?php 
											$prom=array($row['id'],1); $id_adANDnumber=implode(".",$prom); //prvi parametar id predmeta, a drugi kolicina							
											?> 
											<a href="addCart.php?a=<?php echo $id_adANDnumber;?> class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Dodaj u korpu</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h4 > <a href="proizvod_karakteristike.php?a=<?php echo $row['id'];?>"> <?php echo $row['title']; ?> </a> </h4>
												<p><?php if($row['cost']!=0) echo $row['cost']." EUR"; else echo "kontakt EUR"; ?></p>
												<a href="addCart.php?a=<?php echo $id_adANDnumber;?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Dodaj u korpu</a>
											</div>
										</div>
								</div> <br>
								  
							</div>
						</div> 					
						<?php 
							}										
						?>					
				</div>
			</div>
		</div>
	</section>
	
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