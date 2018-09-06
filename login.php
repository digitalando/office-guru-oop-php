<?php require_once('./php/requires.php'); ?>
<?php 
if (isLoggedIn()) 
{
	header('location: index.php');
	exit;
} 

$email = $_POST['email'] ?? null;

if ($_POST)
{
	$myUserCtrl = new OfficeGuru\Controllers\UserController();
	$myUserCtrl->loginAction($_POST);
}

$viewMessages = $GLOBALS['view']['messages'] ?? [];
?>
<?php $bodyClass = 'page-login menu-inverse'; ?>
<?php require_once('header.php'); ?>

<main>
	<section class="user-form">
		<div class="container">
			<h2 class="pad-left pad-right">Iniciar Sesión</h2>
			<div class="legal-text">
				<h4>¿Todavía no formás parte? <a href="register.php">Creá tu cuenta</a></h4>
			</div>

			<?php if($viewMessages) { ?>
				<div class="row">		
					<div class="col-6 col-sm-12 col-centered">
						<div class="alert alert-danger">
							<?php foreach($viewMessages as $field => $message) : ?>
								<?php echo $message ?><br>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php } ?>

			<!--Empieza el form de registro -->
			<div class="pad-left pad-right pad-half-top">
				<form class="form-login" action="" method="post">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" class="form-control" id="email" placeholder="mmouse@disney.com" value="<?php echo $email; ?>">
					</div>

					<div class="form-group">
						<label for="password">Contraseña</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="Ingrese Contraseña">
					</div>

					<label class="terms"><input type="checkbox" name="remember_me"> Recordarme</label>

					<input type="submit" class="btn btn-register" value="Iniciar Sesión">

				</form>
				<div class="legal-text">
					<p><a href="recover-form.php">¿Olvidaste la contraseña?</a></p>
				</div>
			</div>
		</div>
	</section>
</main>



<?php require_once('footer.php'); ?>