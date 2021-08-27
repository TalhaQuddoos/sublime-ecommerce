<?php

require_once("__func__.php");

$categories = $Product->getAllCategories();
$categories = array_column($categories, 'product_category');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Categories</title>
	<?php include("templates/_meta.php"); ?>
	<link rel="stylesheet" href="assets/css/categories.css">

</head>

<body>
	<div class="super_container">
		<?php include("templates/_header.php"); ?>
		<?php include("templates/_menu.php"); ?>

		<div class="home">
			<div class="home_container">
				<div class="home_background" style="background-image:url(assets/images/categories.jpg)"></div>
				<div class="home_content_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content">
									<div class="home_title">Browse Categories<span>.</span></div>
									<div class="home_text">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam a ultricies
											metus. Sed nec molestie eros. Sed viverra velit venenatis fermentum luctus.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="products mt-5 mb-5" >
			<div class="container" style="margin-top: 150px;">
				<div class="row justify-content-center">
					<div class="col-11">


						<div class="product_grid row justify-content-start">
							<?php foreach($categories as $category): ?>
							<div class="product col-lg-3 col-md-4 col-sm-6 col-6">
								<div class="product_image text-center" style="height: 200px;"><img src="assets/images/categories/<?=$category?>.jpg" style="max-height: 200px;" alt="" class="text-center"></div>
								<div class="product_content">
									<div class="product_title text-center"><a href="/products?category=<?=$category?>"><?=ucwords($category)?>s</a></div>
								</div>
							</div>
							<?php endforeach; ?>

						</div>





						<div class="product_pagination">
							<ul>
								<li class="active"><a href="#">01.</a></li>
								<li><a href="#">02.</a></li>
								<li><a href="#">03.</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("templates/_footer.php"); ?>
	</div>
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/plugins_main.js"></script>
	<script src="assets/js/pagespeed.js"></script>
</body>

</html>