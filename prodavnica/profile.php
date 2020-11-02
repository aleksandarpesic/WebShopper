<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Contact </title>
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
								<li><a href=""><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href=""><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href=""><i class="fa fa-facebook"></i></a></li>
								<li><a href=""><i class="fa fa-twitter"></i></a></li>
								<li><a href=""><i class="fa fa-linkedin"></i></a></li>
								<li><a href=""><i class="fa fa-dribbble"></i></a></li>
								<li><a href=""><i class="fa fa-google-plus"></i></a></li>
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
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="">Canada</a></li>
									<li><a href="">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="">Canadian Dollar</a></li>
									<li><a href="">Pound</a></li>
								</ul>
							</div>
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
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.html">Home</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Products</a></li>
										<li><a href="product-details.html">Product Details</a></li> 
										<li><a href="checkout.html">Checkout</a></li> 
										<li><a href="cart.html">Cart</a></li> 
										<li><a href="login.html">Login</a></li> 
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
										<li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li> 
								<li><a href="404.html">404</a></li>
								<li><a href="contact-us.html" class="active">Contact</a></li>
							</ul>
						</div>
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
	$result=queryMysql("SELECT * FROM `members` WHERE `id`='$id' ");
	if(isset($_POST['name']) && $_POST['name']!="" ){  //update ime
		$text=sanitizeString($_POST['name']);
		$text=preg_replace('/\s+/', ' ', $text);// ako ima vise od jednog space u tekstu smanjuje na jedan space
		if($result->num_rows){
			queryMysql("UPDATE `members` SET `name`='$text' WHERE `id`=$id");
		}
	}
	if(isset($_POST['last_name']) && $_POST['last_name']!="" ){  //update prezime
		$text=sanitizeString($_POST['last_name']);
		$text=preg_replace('/\s+/', ' ', $text);// ako ima vise od jednog space u tekstu smanjuje na jedan space
		if($result->num_rows){
			queryMysql("UPDATE `members` SET `last_name`='$text' WHERE `id`=$id");
		}
	}
	if(isset($_POST['email'])&& $_POST['email']!=""){  //update email
		$emtmp=$_POST['email'];
		$resultSecurity=queryMysql("SELECT * FROM `members` WHERE `email`='$emtmp' ");
		if ($resultSecurity->num_rows) {
			$error="<span class='error'>Nije moguce izmeniti Email adresu. U bazi vec postoji korisnik sa ovom adresom.</span>";
		} else {
		$text=sanitizeString($_POST['email']);
		$text=preg_replace('/\s+/', ' ', $text);// ako ima vise od jednog space u tekstu smanjuje na jedan space
		if($result->num_rows){
			queryMysql("UPDATE `members` SET `email`='$text' WHERE `id`=$id");
		} 
		}
	}
	if(isset($_POST['pass']) && $_POST['pass']!="" && $_POST['pass2']!=""){  //update pass
		if ($_POST['pass'] != $_POST['pass2']) {
			$error="<span class='error'>Lozinke se ne poklapaju</span>"; 
		} else if ($_POST['pass'] == $_POST['pass2']){
			$pass=$_POST['pass'];
			$hpassR=hash('ripemd128', "$salt1$pass$salt2");
			if($result->num_rows){
				queryMysql("UPDATE `members` SET `pass`='$hpassR' WHERE `id`=$id");
			}
		}
	}
	
	//deo za upload fotke
	if(isset($_FILES['image']['name'])){
		$saveto="$id.jpg";
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
			$max=100;
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
		}
	}
	
		
	$src_picture="$id.jpg"
	
	?>
	 	
	 			
	    <form method="post" action="profile.php" enctype="multipart/form-data" id="main-contact-form" class="contact-form row">
	    
			<h3>Izmenite podatke ili sliku</h3>
				<div class="form-group col-md-6"> 
				<?php
				$result=queryMysql("SELECT * FROM `members` WHERE `id`=$id"); 
				$row=$result->fetch_array(MYSQLI_ASSOC); 
				?>
				             Ime:  <input type="text" name="name" class="form-control"  placeholder="<?php echo $row['name'];  ?>">
				            </div> 
				            <div class="form-group col-md-6">
				              Prezime:  <input type="text" name="last_name" class="form-control"  placeholder="<?php echo $row['last_name']; ?>">
				            </div>
				            <div class="form-group col-md-12">
				               Email: <input type="email" name="email" class="form-control"  placeholder="<?php echo $row['email']; ?>">
				            </div>
				             <div class="form-group col-md-6">
				               Nova lozinka: <input type="password" name="pass" class="form-control" >
				               Ponovi lozinku: <input type="password" name="pass2" class="form-control" > <?php echo $error; ?>
				            </div>
			<label for="image">Profilna slika:</label>
			<input type="file" name="image" id="image"> <br>
			<input type="submit" value="Zapamti izmene">
	</form>
				    	
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center"></h2>
	    				 <img src="<?php echo $src_picture;  ?>" alt="Nemate sliku" > 
	    				<div class="social-networks">
	    					<h2 class="title text-center">Social Networking</h2>
							<ul>
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-google-plus"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-youtube"></i></a>
								</li>
							</ul>
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
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe1.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe2.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe3.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/home/iframe4.png" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Online Help</a></li>
								<li><a href="">Contact Us</a></li>
								<li><a href="">Order Status</a></li>
								<li><a href="">Change Location</a></li>
								<li><a href="">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">T-Shirt</a></li>
								<li><a href="">Mens</a></li>
								<li><a href="">Womens</a></li>
								<li><a href="">Gift Cards</a></li>
								<li><a href="">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Terms of Use</a></li>
								<li><a href="">Privecy Policy</a></li>
								<li><a href="">Refund Policy</a></li>
								<li><a href="">Billing System</a></li>
								<li><a href="">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="">Company Information</a></li>
								<li><a href="">Careers</a></li>
								<li><a href="">Store Location</a></li>
								<li><a href="">Affillate Program</a></li>
								<li><a href="">Copyright</a></li>
							</ul>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
		
		
		
	</footer><!--/Footer-->
	

  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="js/gmaps.js"></script>
	<script src="js/contact.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>