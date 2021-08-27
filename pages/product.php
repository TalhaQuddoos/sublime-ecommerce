<!DOCTYPE html>
<html lang="en">

<head>
	<title>Product</title>
	<?php include(__DIR__ . "/../templates/_meta.php"); ?>
	<link rel="stylesheet" href="/assets/css/product.css">

	<?php

	include("__func__.php");
	$id = $_GET['id'] ?? null;
	if(!$id) header("Location: /products");

	$product = $Product->getProduct($id);
	if(!$product) header("Location: /products");
	
	$relatedProducts = $Product->getRandomProducts(4, $category = $product['product_category'], $exclude=$product['product_id']);
	if ($Auth->isLoggedIn() && $Cart->checkInCart($product['product_id'])) {
		[$itemId, $quantity] = $Cart->checkInCart($product['product_id']);
	} else {
		[$itemId, $quantity] = [false, 1];
	}



	?>
</head>

<body>
	<div class="super_container">

		<?php include(__DIR__ . "/../templates/_header.php"); ?>
		<?php include(__DIR__ . "/../templates/_menu.php"); ?>

		<div class="product_details" data-item-id="<?= $itemId ? $itemId : "false" ?>" style="margin-top: 200px">
			<div class="container">
				<div class="row details_row">

					<div class="col-lg-6 mt-5">
						<div class="details_image">
							<div class="details_image_large text-center"><img src="<?= $product['product_thumbnail'] ?>" alt="" style="max-height: 300px;">
							</div>
							<div class="details_image_thumbnails d-flex flex-row align-items-start justify-content-start row">
								<?php foreach ($product['product_images'] as $product_image) : ?>
									<div class="details_image_thumbnail col-2 mt-3 text-center">
										<img src="<?= $product_image ?>" style="height: 50px;" alt="">
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="details_content">
							<div class="details_name"><?= $product['product_name'] ?></div>
							<div class="details_discount">$<?php echo round($product['product_price'] * 1.5, 2) ?></div>
							<div class="details_price">$<?= $product['product_price'] ?></div>

							<div class="in_stock_container">
								<div class="availability">Availability:</div>
								<span>In Stock</span>
							</div>
							<div class="details_text">
								<p><?= $product['product_description'] ?></p>
							</div>

							<div class="product_quantity_container">
								<div class="product_quantity clearfix">
									<span>Qty</span>
									<input id="quantity_input" type="text" pattern="[0-9]*" value="<?= $quantity ?>">
									<div class="quantity_buttons">
										<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
										<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
									</div>
								</div>
								<div class="button cart_button <?= $itemId ? "remove" : "" ?>">
									<a href="#" data-action="<?= $itemId ? "remove" : "add" ?>">
										<?= $itemId ? "Remove from cart" : "Add to cart" ?>
									</a>
								</div>
							</div>

							<div class="details_share">
								<span>Share:</span>
								<ul>
									<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row description_row">
					<div class="col">
						<div class="description_title_container">
							<div class="description_title">Description</div>
							<div class="reviews_title"><a href="#">Reviews <span>(1)</span></a></div>
						</div>
						<div class="description_text">
							<p><?= $product['product_description'] ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="products">
			<div class="container">
				<div class="product_grid row">
					<?php foreach ($relatedProducts as $relatedProduct) : ?>
						<div class="product col-lg-3 col-md-4 col-sm-6 col-6" style="height: 300px;">
							<div class="product_image text-center" style="height: 200px;"><img src="<?= $relatedProduct['product_thumbnail'] ?>" alt="" style="max-height: 200px;"></div>
							<div class="product_content">
								<div class="product_title"><a href="/product?id=<?= $relatedProduct['product_id'] ?>" style="max-height: 100px;" class="text-truncate d-block"><?= $relatedProduct['product_name'] ?></a></div>
								<div class="product_price">$<?= $relatedProduct['product_price'] ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>


		<?php include(__DIR__ . "/../templates/_footer.php") ?>
	</div>
	<script src="/assets/js/jquery-3.2.1.min.js"></script>
	<script src="/assets/js/owl.carousel.js"></script>
	<script src="/assets/js/plugins_main.js"></script>
	<script src="/assets/js/pagespeed.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<script>
		const quantityContainer = document.getElementById("quantity_input");
		const quantityControls = document.querySelectorAll(".quantity_control");
		const thumbnails = document.querySelectorAll(".details_image_thumbnail");
		const cartButton = document.querySelector(".button.cart_button");
		const deleteButtons = document.querySelectorAll(".fa-trash");
		var isLoggedIn = <?= $Auth->isLoggedIn() ? "true" : "false" ?>;


		function handleQuantity(e) {
			if (!isLoggedIn) window.location.href = `/login?return=/product?id=<?= $product['product_id'] ?>&qty=${quantityContainer.value}`;

			var action = e.target.id.split("_")[1]

			var currentQuantity = parseInt(quantityContainer.value);
			var newQuantity = action == "inc" ? ++currentQuantity : --currentQuantity;
			if (newQuantity <= 0) return false;

			var inCart = document.querySelector("[data-action]").dataset.action == "remove";
			if (inCart) {
				var itemId = document.querySelector("[data-item-id]").dataset.itemId;

				updateQuantity(itemId, newQuantity);

			}
			quantityContainer.value = newQuantity;


		}



		function handleCartButton(e) {
			e.preventDefault();
			if (!isLoggedIn) window.location.href = `/login?return=/product?id=<?= $product['product_id'] ?>&qty=${quantityContainer.value}`;

			e.target.innerHTML = `<i class="fa fa-spinner fa-2x fa-spin" style="margin-top: 10px!important;"></i>`;

			var buttonAction = document.querySelector("[data-action]").dataset.action;
			if (buttonAction == "remove") {
				var itemId = document.querySelector("[data-item-id]").dataset.itemId;
				removeFromCart(itemId);

			} else {
				var productId = <?= $product['product_id'] ?>;
				var quantity = parseInt(quantityContainer.value);
				addToCart(productId, quantity)
			}
		}



		function handleThumbnails(e) {
			document.querySelector(".details_image_large").children[0].src = e.target.src || e.target.children[0].src;
		}

		function addToCart(productId, quantity) {


			axios.post('/requestHandler', {
				id: productId,
				quantity: quantity,
				action: "addToCart"
			}).then(({
				data: id
			}) => {
				document.querySelector("[data-item-id]").dataset.itemId = id;
				const btn = document.querySelector("[data-action]")
				btn.dataset.action = "remove";
				btn.innerHTML = "Remove from cart"
				btn.parentElement.classList.add("remove");
				syncCartCount();
			});

		}

		async function removeFromCart(itemId) {

			const res = await axios.post('/requestHandler', {
				id: itemId,
				action: "deleteCartItem"
			}).then(() => {
				const btn = document.querySelector("[data-action]")
				btn.dataset.action = "add";
				btn.innerHTML = "Add to cart"
				btn.parentElement.classList.remove("remove");
				quantityContainer.value = 1;
				syncCartCount();
			});
		}

		async function updateQuantity(itemId, newQuantity) {
			const res = await axios.post('/requestHandler', {
				id: itemId,
				quantity: newQuantity,
				action: "updateCartQuantity"
			});
		}

		async function syncCartCount() {
			await axios.post('/requestHandler', {
				action: "getCartCount"
			}).then(({data}) => {
				document.getElementById("cartCount").innerHTML = data;
			})
		}

		quantityControls.forEach(item => {
			item.addEventListener("click", handleQuantity)
		})

		thumbnails.forEach(item => {
			item.addEventListener("click", handleThumbnails)
		})

		cartButton.addEventListener("click", handleCartButton)
	</script>


</html>