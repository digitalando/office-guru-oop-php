<?php 
require_once('./php/requires.php'); 

$myUserCtrl = new OfficeGuru\Controllers\UserController();
$maxFileSize = OfficeGuru\Forms\UserProfileForm::IMAGE_MAX_FILESIZE;
$isLoggedIn = $myUserCtrl->isLoggedIn();
if (!$isLoggedIn) 
{
	header('location: index.php');
	exit;
} 

if ($_POST)
{
	$myUserCtrl->profileAction($_POST, $_FILES);
}

$myUser = $_SESSION['og_user'];

$viewMessages = $GLOBALS['view']['messages'] ?? [];

?>
<?php $bodyClass = 'page-profile menu-inverse' ?>
<?php require_once('header.php'); ?>
<main>
	<section class="user-form">
		<div class="container">
			<?php if($viewMessages) { ?>
					<div class="alert alert-danger">
					<?php foreach($viewMessages as $field => $message) {
						echo $message . '<br>';
					}?>
					</div>
			<?php } ?>

			<div class="txt-center">
				<img class="avatar avatar-lg" src="<?php echo $myUser::IMAGE_PATH . $myUser->getImage() ?>" alt="<?php echo $_SESSION['user']['first_name']; ?>"> 
			</div>

			<div class="pad-left pad-right pad-half-top">
				<!--Empieza el form de registro -->
				<form class="form-register" enctype="multipart/form-data" action="" method="post">
					<!-- 
						Tamaño máximo de imagen en bytes. Esto es sólo para cortar la transferencia en caso de que se pase del tamaño
						pero de igual manera debe validarse del lado del servidor.
					-->
					<input type="hidden" name="id" value="<?php echo $myUser->getId(); ?>" />
					<input type="hidden" name="image" value="<?php echo $myUser->getImage(); ?>" />
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxFileSize; ?>" />
					
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" id="email" value="<?php echo $myUser->getEmail(); ?>">
						<!--<i class="icon-mail-alt"></i>-->
					</div>

					<div class="form-group">		
						<label for="first_name">Nombre</label>
						<input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo $myUser->getFirstName(); ?>">
					</div>

					<div class="form-group">		
						<label for="last_name">Apellido</label>
						<input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo $myUser->getLastName(); ?>">
					</div>

					<div class="form-group">		
						<label for="last_name">Imagen</label>
						<input type="file" name="new_image" class="form-control" id="new_image" value="">
						<p>La imagen debe ser de al menos 400px x 400px y deberá pesar menos de 5 Mb.</p>
					</div>

					<input type="submit" class="btn btn-register" value="Actualizar mis datos">
					
				</form>
			</div>

		</div>
	</section>
</main>

<?php require_once('footer.php'); ?>