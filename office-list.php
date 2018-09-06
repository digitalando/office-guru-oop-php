<?php
$offices = [
	[
		'title' => 'Oficina 1',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-1.jpg',
		'price' => '231',
		'services' => [
			'icon-instagram' => 'WiFi',
			'icon-clock' => 'Electricidad',
			'icon-star' => 'Infusiones',
		],
		'rating' => 3.5,
		'ratingCount' => 12,
	], [
		'title' => 'Oficina 2',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-2.jpg',
		'price' => '123',
		'services' => [
			'icon-star' => 'Infusiones',
			'icon-instagram' => 'WiFi',
		],
		'rating' => 4.5,
		'ratingCount' => 34,
	], [
		'title' => 'Oficina 3',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-3.jpg',
		'price' => '422',
		'services' => [
			'icon-instagram' => 'Electricidad',
			'icon-clock' => 'WiFi',
		],
		'rating' => 4.6,
		'ratingCount' => 5,
	], [
		'title' => 'Oficina 4',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-1.jpg',
		'price' => '223',
		'services' => [
			'icon-instagram' => 'WiFi',
			'icon-clock' => 'Electricidad',
			'icon-star' => 'Infusiones',
		],
		'rating' => 3.5,
		'ratingCount' => 55,
	], 	[
		'title' => 'Oficina 1',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-2.jpg',
		'price' => '482',
		'services' => [
			'icon-instagram' => 'WiFi',
			'icon-clock' => 'Electricidad',
			'icon-star' => 'Infusiones',
		],
		'rating' => 4,8,
		'ratingCount' => 33,
	], [
		'title' => 'Oficina 2',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-3.jpg',
		'price' => '821',
		'services' => [
			'icon-instagram' => 'WiFi',
			'icon-star' => 'Infusiones',
		],
		'rating' => 4,
		'ratingCount' => 8,
	], [
		'title' => 'Oficina 3',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-1.jpg',
		'price' => '235',
		'services' => [
			'icon-star' => 'Infusiones',
		],
		'rating' => 3,2,
		'ratingCount' => 11,
	], [
		'title' => 'Oficina 4',
		'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
		'image' => 'img\locations\office-2.jpg',
		'price' => '500',
		'services' => [
			'icon-clock' => 'Electricidad',
			'icon-star' => 'Infusiones',
		],
		'rating' => 4.5,
		'ratingCount' => 14,
	], 
];
?>

	<section class="offices pad-top">
		<div class="container">
			<h2>Oficinas destacadas</h2>
			
			<div class="row office-list">
				<?php foreach ($offices as $office) { ?>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<article class="office">
						<img src="<?php echo $office['image'] ?>" alt="<?php echo $office['title'] ?>">
						<p>
							<strong>$<?php echo $office['price'] ?> ARS / DÍA</strong>
							<span class="services">
								<?php foreach ($office['services'] as $icon => $desc) { ?>
								<i class="<?php echo $icon ?>" title="<?php echo $desc ?>"></i>
								<?php } ?>	
							</span>
						</p>
						<p><?php echo $office['desc'] ?></p>
						<ul class="stars">
							<?php
								$fullStars = floor($office['rating'] / 2);
								for ($j = $fullStars; $j >= 1 ; $j--) { 
							?>
							<li><i class="icon-star"></i></li>
							<?php 
								} 
								if (($office['rating'] - $fullStars * 2) >= .5) {
							?>
							<li><i class="icon-star-half"></i></li>
							<?php } ?>	
							<li><?php echo $office['ratingCount'] > 0 ? $office['ratingCount'] . ' evaluaciones': 'Se el primero en evaluarla'; ?> </li>
						</ul>
					</article>
				</div>
				<?php } ?>			
			</div>
		</div>
	</section> 	