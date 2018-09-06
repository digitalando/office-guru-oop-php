<?php require_once('./php/requires.php'); ?>
<?php 
if (isLoggedIn()) 
{
	header('location: index.php');
	exit;
}

$errors = [];
if($_GET)
{
	$token = validateRecoverToken($_GET['token']);
	if(!$token)
	{
		$errors[] = 'El token no es valido';
	}
	else
	{
		autoLoginByUserId($token['userId']);
		header('location: profile.php');
	}
}
?>
<?php $bodyClass = 'page-profile menu-inverse' ?>
<?php require_once('header.php'); ?>
<main>
	<section class="user-form">
		<div class="container">
			<h2 class="pad-left pad-right">Haz solicitado recuperar tu contraseña</h2>

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

			<div class="legal-text">
				<p><a href="recover-form.php">Recuperar contraseña</a></p>
			</div>

		</div>
	</section>
</main>

<?php require_once('footer.php'); ?>