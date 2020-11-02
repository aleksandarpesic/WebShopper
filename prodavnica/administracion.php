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
	$ad_entered=" ";
	if($loggedAdmin == FALSE) die("Samo administrator moze unositi predmete");
	if(isset($_POST['title']) && $_POST['title']!=""  ){   
		if (! isset($_POST['category_id']) || $_POST['category_id']=="" ) { $error="<span class='error'>Broj kategorije je obavezno polje</span>"; }
		if (! isset($_POST['sub_category_id']) || $_POST['sub_category_id']=="" ) { $error="<span class='error'>Broj pod kategorije je obavezno polje</span>"; }
		if (! isset($_POST['text']) || !strlen(trim($_POST['text'])) ) { $error="<span class='error'>Tekst proizvoda je obavezno polje</span>"; }
		 
		if($error==" "){
		$title=$_POST['title'];
		$text=$_POST['text'];
		$category_id=$_POST['category_id'];
		$sub_category_id=$_POST['sub_category_id'];
		$cost=$_POST['cost'];
		$url=$_POST['url'];
		
		$result=mysqli_query($connection,"select place($category_id,$sub_category_id )");
		$res=mysqli_fetch_row($result);
			
		queryMysql("INSERT INTO `ad` (`title`, `text`, `place_category_id`, `cost`, `url`) VALUES 
				('$title', '$text', $res[0] , '$cost', '$url' )	");
		$ad_entered="<h3>Oglas je uspesno upisan</h3>";
		
		//uzimam id da bi kasnije mogo da nazovem sliku kao trenutni id.jpg
		$result=queryMysql("SELECT * FROM `ad` WHERE `title`='$title'"); 
		$row=$result->fetch_assoc(); //niz koji ima elemente koji odgovaraju kolonama iz baze podataka
		$idAD=$row['id'];
		}
	} else 
		if(isset($_POST['text']) || isset($_POST['category_id']) )	{ 
			$error="<span class='error'>Naslov je obavezno polje</span>"; 
		}
		
		
	
	//deo za upload fotke
	if(isset($_FILES['image']['name']) && $error==" " ){
		
		$saveto="products_image/".$idAD.".jpg";
		move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
	
		switch($_FILES['image']['type']	) {
			case "image/gif":
				$src=imagecreatefromgif($saveto); $typeok=TRUE;
				break;
			case "image/jpeg": case "image/pjpeg": $typeok=TRUE;
				$src=imagecreatefromjpeg($saveto);
				break;
			case "image/png":
				$src=imagecreatefrompng($saveto); $typeok=TRUE;
				break;
			default:
				$typeok=FALSE;
				break;
		}
	
		//$typeok=TRUE;
	
		if($typeok){
			list($w,$h)=getimagesize($saveto);
			$max=300;
			$tw=$w;
			$th=$h;
			
			
			if($w>$h && $w>$max){
				$tw=$max;
				$th=$max / $w * $h;				
			}
			elseif($h>$w && $h>$max){
				$th=$max;
				$tw=$max / $h * $w;
			}
			elseif($w>$max){ //ako su istih dimenzija
				$th=$tw=$max;
			}
			$tmp = imagecreatetruecolor($tw, $th);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
			imageconvolution($tmp, array(array(-1,-1,-1),
					array(-1,16,1),array(-1,-1,-1)
			), 8, 0); //transformacije nad slikom
			imagejpeg($tmp,$saveto); //iz tmp prebacuje iz tmp u saveto
			imagedestroy($tmp);
			imagedestroy($src);
			
			
			if($error==" ") queryMysql("UPDATE `ad` SET `file_path`='$saveto' WHERE `title`='$title' ");
			
		}
	}
	
		
	
	
	?>
	 	
	 			
	    <form method="post" action="administracion.php" enctype="multipart/form-data" id="main-contact-form" class="contact-form row">
	    	<?php echo $ad_entered; echo "<br>"; ?>
			<h3>Upis novog predmeta</h3> <br>
			
				<div class="form-group col-md-12"> 
				
				             Naslov:  <input type="text" name="title" class="form-control"  placeholder="">
				            </div> <p>
				            <div class="form-group col-md-6">
				              Kategorija:  <input type="text" name="category_id" class="form-control"  placeholder="Uneti broj kategorije a ne ime">
				            </div>
							<div class="form-group col-md-6">
				              Pod Kategorija:  <input type="text" name="sub_category_id" class="form-control"  placeholder="Uneti broj pod kategorije a ne ime">
				            </div> </p>
				            Sadrzaj:  <textarea name="text" cols="100" rows="10">
				           								
							</textarea>
				            <div class="form-group col-md-12">
				               Cena: <input type="text" name="cost" class="form-control"  placeholder="">
				            </div>
				             <div class="form-group col-md-6">
				               Url: <input type="text" name="url" class="form-control" >				              
				            </div>
			<label for="image">Slika:</label>
			<input type="file" name="image" id="image"> <br> <?php echo $error; ?>
			<input type="submit" value="Zapamti izmene">
	</form>
				    	
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center"></h2>
	    				 
	    				<div class="social-networks">
	    					<h2 class="title text-center">Moguce kategorije</h2>
							<ul>
							<?php 
							$result= queryMysql("SELECT `id`, `name` FROM `category`");
							$num=$result->num_rows;
							
							for($j=0; $j<$num;$j++){
								$row=$result->fetch_assoc(); // trenutni slog
								?>
								 <li>
								<?php  echo $row['id']." - ". $row['name']	?>							
							 </li> <br>
							 <?php 
							} ?>								
							</ul> 
							<br> 
							<h2 class="title text-center">Moguce Pod kategorije</h2>
							<ul>
							<?php 
							$result= queryMysql("SELECT `id`, `name` FROM `sub_category`");
							$num=$result->num_rows;
							
							for($j=0; $j<$num;$j++){
								$row=$result->fetch_assoc(); // trenutni slog
								?>
								 <li>
								<?php  echo $row['id']." - ". $row['name']	?>							
							 </li> <br>
							 <?php 
							} ?>								
							</ul>
							<br> <br> <br>
							<?php 
								$cetegoryAdded="";
								$cat_name="";
								if (isset($_POST['new_category'])){
									$cat_name=strtoupper($_POST['new_category']);
									$result= queryMysql("SELECT * FROM `category` WHERE `name`='$cat_name' ");
									$num=$result->num_rows;
									if($num > 0){
										$cetegoryAdded="Kategorija vec postoji u bazi";
									}
									else{
									queryMysql("INSERT INTO `category` (`name`) VALUES ('$cat_name') ");
									$cetegoryAdded="Kategorija dodata";
									}
								}
								
								$sub_cetegoryAdded="";
								$sub_cat_name="";
								if (isset($_POST['new_sub_category'])){
									$sub_cat_name=strtoupper($_POST['new_sub_category']);
									$result= queryMysql("SELECT * FROM `category` WHERE `name`='$sub_cat_name' ");
									$num=$result->num_rows;
									if($num > 0){
										$sub_cetegoryAdded="Pod kategorija vec postoji u bazi";
									}
									else{
									queryMysql("INSERT INTO `sub_category` (`name`) VALUES ('$sub_cat_name') ");
									$sub_cetegoryAdded="Pod kategorija dodata";
									}
								}
							?>
							
							 <form method="post" action="administracion.php" enctype="multipart/form-data" id="main-contact-form" class="contact-form row">
							<h2 class="title text-center">Dodaj novu kategoriju</h2>
							 <div class="form-group col-md-12">
				              Kategorija:  <input type="text" name="new_category" class="form-control"  placeholder="Uneti naziv kategorije">				              
				            </div> <br>
				            <input type="submit" value="Unesi">				            
							</form>
							<br><br>
							 <form method="post" action="administracion.php" enctype="multipart/form-data" id="main-contact-form" class="contact-form row">
							<h2 class="title text-center">Dodaj novu pod-kategoriju</h2>
							 <div class="form-group col-md-12">
				              Kategorija:  <input type="text" name="new_sub_category" class="form-control"  placeholder="Uneti naziv kategorije">				              
				            </div> <br>
				            <input type="submit" value="Unesi">				            
							</form> <br>
							<p><?php echo $cetegoryAdded; ?> </p>
							<p><?php echo $sub_cetegoryAdded; ?> </p>
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