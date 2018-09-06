<?php require_once('./php/requires.php'); ?>
<?php 
if (isLoggedIn()) 
{
	header('location: index.php');
	exit;
}

$errors = [];
if($_POST)
{
	$user = findByField('email', $_POST['email']);
	if(!$user)
	{
		$errors[] = 'El email no se encuentra en nuestra base de datos';
	}
	else
	{
		$token = new UsersTokens($user['id']);
		header('location: recover-email.php?token=' . $token->generate());
		exit;
	}
}

$email = $_SESSION['user']['email'] ?? null;

?>
<?php $bodyClass = 'page-profile menu-inverse' ?>
<?php require_once('header.php'); ?>
<main>
	<section class="user-form">
		<div class="container">
			<h2 class="pad-left pad-right">¿Olvidaste la contraseña?</h2>
			<div class="legal-text">
				<h4>Ingresá tu email y te enviaremos instrucciones para reiniciarla.</h4>
			</div>

			<?php if($errors) { ?>
				<div class="row">				
					<div class="col-6 col-centered">
						<div class="alert alert-warning">
							<?php foreach($errors as $error) {
								echo $error . '<br>';
							}?>
						</div>
					</div>
				</div>
			<?php } ?>

			<div class="pad-left pad-right pad-half-top">
				<!--Empieza el form de registro -->
				<form class="form-register" action="" method="post">

					<div class="form-group">
						<input type="email" name="email" class="form-control" id="email" placeholder="Email" ="">
						<!--<i class="icon-mail-alt"></i>-->
					</div>

					<input type="submit" class="btn btn-register" value="Recuperar mi contraseña">
					<div class="legal-text">
						<p>¿Ya te acordaste la contraseña? <a href="login.php">Iniciá Sesión</a></p>
					</div>
				</form>
			</div>

		</div>
	</section>
</main>

<?php require_once('footer.php'); ?>