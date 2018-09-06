<?php 
require_once('./php/requires.php');

$myUserCtrl = new OfficeGuru\Controllers\UserController();
$isLoggedIn = $myUserCtrl->isLoggedIn();
if (!$isLoggedIn) 
{
	header('location: index.php');
	exit;
} 

$email = $_POST['email'] ?? null;
$firstName = $_POST['first_name'] ?? null;
$lastName = $_POST['last_name'] ?? null;
$newsletter = $_POST['newsletter'] ?? null;

if ($_POST)
{
	$myUserCtrl->registerAction($_POST);
}

$viewMessages = $GLOBALS['view']['messages'] ?? [];
?>
<?php $bodyClass = 'page-register menu-inverse' ?>
<?php require_once('header.php'); ?>
<main>
	<section class="user-form">
		<div class="container">
			<h2>Registrate ahora y empezá a trabajar desde donde quieras</h2>
			<div class="legal-text">
				<h4>¿Ya tenés cuenta? <a href="login.php">Iniciá Sesión</a></h4>
			</div>

			<?php if($viewMessages) { ?>
					<div class="alert alert-danger">
					<?php foreach($viewMessages as $field => $message) {
						echo $message . '<br>';
					}?>
					</div>
			<?php } ?>

			<div class="pad-left pad-right pad-half-top">
				<!--Empieza el form de registro -->
				<form class="form-register" action="" method="post">

					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" id="email" placeholder="mmouse@disney.com" value="<?php echo $email; ?>">
						<!--<i class="icon-mail-alt"></i>-->
					</div>

					<div class="form-group">		
						<label for="first_name">Nombre</label>
						<input type="text" name="first_name" class="form-control" id="first_name" placeholder="Jose" value="<?php echo $firstName; ?>">
					</div>


					<div class="form-group">		
						<label for="last_name">Apellido</label>
						<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Canseco" value="<?php echo $lastName; ?>">
					</div>
			
					<div class="form-group">
						<label for="password">Contraseña</label>
						<input type="password" name="password" class="form-control" id="password" placeholder="Ingrese Contraseña">
					</div>

					<div class="form-group">
						<label for="pass_confirm">Confirmar Contraseña</label>
						<input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Confirmar Contraseña">
					</div>

					<input type="submit" class="btn btn-register" value="Registrarme">

					<div class="legal-text">
						<!-- <label for="terms" class="terms">
							<input type="checkbox" id="newsletter" name="newsletter"> Me gustaría recibir cupones, promociones, encuestas y actualizaciones por correo electrónico sobre OfficeGuru y sus socios.
						</label> -->
						<p>Al hacer clic en Registrarme, acepto los <a href="#" target="_blank">términos y condiciones del servicio.</a></p>
					</div>

					
				</form>
			</div>

		</div>
	</section>
</main>

<?php require_once('footer.php'); ?>