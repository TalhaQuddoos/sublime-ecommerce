<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sublime</title>
	<?php include("templates/_meta.php"); ?>
	<link rel="stylesheet" type="text/css" href="assets/css/style_main.css" />

	<?php
		require_once("__func__.php");
		
		$products = $Product->getRandomProducts(8);
	?>
</head>

<body>
	<div class="super_container">
		
		<?php include("templates/_header.php"); ?>
		<?php include("templates/_menu.php"); ?>
		<?php include("templates/_home_slider.php"); ?>
		<?php include("templates/_avds.php") ?>

		<div class="products">
			<div class="container">
				<div class="product_grid row">
					<?php foreach($products as $product) :?>
					<div class="product col-lg-3 col-md-4 col-sm-6 col-6" style="height: 300px;">
						<div class="product_image text-center"><img src="<?=$product['product_thumbnail']?>"></div>
						<div class="product_content">
							<div class="product_title"><a href="/product?id=<?=$product['product_id']?>" style="max-height: 100px;" class="text-truncate d-block"><?=$product['product_name']?></a></div>
							<div class="product_price">$<?=$product['product_price']?></div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<?php include("templates/_home_bottom.php") ?>

		<?php include("templates/_footer.php") ?>

	</div>


	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/owl.carousel.js"></script>
	<script src="assets/js/plugins_main.js"></script>
	<script src="assets/js/pagespeed.js"></script>

</body>
</html>