<?php require_once('./php/requires.php'); ?>
<?php $bodyClass = 'page-layout' ?>
<?php require_once('header.php'); ?>
<main>
	<section>
		<div class="container">
			<h2>Headers</h2>
			<hr>
			<h1>Header 1</h1>
			<h2>Header 2</h2>
			<h3>Header 3</h3>
			<h4>Header 4</h4>
			<h5>Header 5</h5>
			<h6>Header 6</h6>
		</div>
	</section>
	<section>
		<div class="container">
			<h2>Avatar images</h2>
			<hr>
			<p>
				<h4>Small image</h4>
				<img class="avatar avatar-sm" src="<?php echo USERS_IMAGES_PATH . 'default.png' ?>" alt="Small image">
			</p>
			<br>
			<p>
				<h4>Medium image</h4>
				<img class="avatar avatar-md" src="<?php echo USERS_IMAGES_PATH . 'default.png' ?>" alt="Medium image">
			</p>
			<br>
			<p>
				<h4>Large image</h4>
				<img class="avatar avatar-lg" src="<?php echo USERS_IMAGES_PATH . 'default.png' ?>" alt="Large image">
			</p>
		</div>
	</section>
	<section>
		<div class="container">
			<h2>Grid System</h2>
			<hr>
			<h4>Regular columns</h4>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
			</div>
			<h4>Irregular columns</h4>
			<div class="row">
				<div class="col-1">
					<div class="module">col-1</div>
				</div>
				<div class="col-2">
					<div class="module">col-2</div>
				</div>
				<div class="col-3">
					<div class="module">col-3</div>
				</div>
				<div class="col-6">
					<div class="module">col-6</div>
				</div>
			</div>
			<h4>Column without padding</h4>
			<div class="row row-no-pad">
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-2">
					<div class="module">col-3</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php require_once('footer.php'); ?>