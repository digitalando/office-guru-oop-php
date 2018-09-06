<?php require_once('./php/requires.php'); ?>
<?php $bodyClass = 'page-faq' ?>
<?php require_once('header.php'); ?>
<main>
	<section class="questions">
		<div class="container">
			<h2>¡Gracias por registrarte!</h2>
			<article class="question txt-center">
				<h4>Tenemos algunas recomendaciones para vos:</h4>
				<div class="welcome-nav-bar">
					<ul>
						<li><a href="profile.php">1. Completá tu perfil personal</a></li>
						<li><a href="">2. Buscá el mejor espacio para vos</a></li>
						<li><a href="">3. Agregá un nuevo espacio</a></li>
						<li><a href="">4. Mirá nuestro blog</a></li>
					</ul>
				</div>
			</article>
		</div>
	</section>
	<?php require_once('office-list.php'); ?>
</main>
<?php require_once('footer.php'); ?>