<?php require_once('./php/requires.php'); ?>
<?php
$myUserCtrl = new OfficeGuru\Controllers\UserController();
$isLoggedIn = $myUserCtrl->isLoggedIn();
if ($isLoggedIn) 
{
	$myUser = $_SESSION['og_user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>OfficeGuru</title>
	<!-- En W3C sugieren esta linea -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Css utilizados -->
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="<?php echo (isset($bodyClass) ? $bodyClass : ''); ?>">

	<header>	
		<div class="container group">
			<div class="row">
				<div class="navbarheader col-lg-12">
					<div class="menus group container">
						<nav class="headernav">
							<div class="headerlogo">
								<h1 class="logo">Office Gurú<a href="index.php"><img src="img/logo.png" alt="Office Guru"></a></h1>
							</div>

							<div id="headernav-menu" class="headernav-menu">	
								<ul>
									<li class="menu-item-host"><a href="register.php">Convertite en gurú</a></li>
									<li class="menu-item-faq"><a href="faq.php">FAQ</a></li>
									<?php if ($isLoggedIn) { ?>
									<li class="menu-item-user">
										<a href="profile.php">
											<img class="avatar avatar-sm" src="<?php echo USERS_IMAGES_PATH . $myUser->getImage(); ?>" alt="<?php echo $myUser->getFirstName(); ?>">
											<?php echo $myUser->getFirstName(); ?>
										</a>
									</li>
									<li class="menu-item-user"><a href="logout.php"><i class="icon-lock"></i> Salir</a></li>
									<?php } else { ?>
									<li class="menu-item-register"><a href="register.php">Registrate</a></li>
									<li class="menu-item-login"><a href="login.php">Ingresá</a></li>
									<?php } ?>
								</ul>
							</div>
							
							
							<button id="menu-mobile" class="hamburger menu-mobile" type="button">
							  <span class="hamburger-box">
							    <span class="hamburger-inner"></span>
							  </span>
							</button>
							<!--<img id="menu-mobile" class="menu-mobile" src="img/menu.png"-->
						</nav>

					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="js/example.js"></script>

	</header>