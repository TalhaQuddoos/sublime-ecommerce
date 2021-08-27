<?php

require_once("__func__.php");

if (!$Auth->isLoggedIn()) {
	header("Location: /login");
}

$cartItems = $Cart->getCartItems();
$totalPrice = $Cart->getCartTotal();
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Cart</title>
	<?php include(__DIR__ ."/../templates/_meta.php"); ?>
	<link rel="stylesheet" href="/assets/css/cart.css">
</head>

<body>
	<div class="super_container">
		<?php include(__DIR__ ."/../templates/_header.php"); ?>
		<?php include(__DIR__ ."/../templates/_menu.php"); ?>

		<div class="home">
			<div class="home_container">
				<div class="home_background" style="background-image:url(assets/images/cart.jpg)"></div>
				<div class="home_content_container">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="home_content w-100">

									<div class="text-white text-center section_title" style="font-size: 40px;">Cart</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="cart_info">
			<div class="container">
				<div class="row">
					<div class="col">

						<div class="cart_info_columns clearfix">
							<div class="cart_info_col cart_info_col_product text-center">Product</div>
							<div class="cart_info_col cart_info_col_price text-center">Price</div>
							<div class="cart_info_col cart_info_col_quantity text-center">Quantity</div>
							<div class="cart_info_col cart_info_col_total text-center">Total</div>
						</div>
					</div>
				</div>

				<div class="row cart_items_row">
					<div class="col">
						<?php if (count($cartItems) > 0) {
							foreach ($cartItems as $cartItem) { ?>

								<div class="row">
									<div class="cart_item d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start w-100" data-price="<?=$cartItem['price']?>">
										<div class="cart_item_product d-flex flex-row align-items-center justify-content-start">
											<div class="cart_item_image text-center col-3">
												<div><img src="<?= $cartItem['thumbnail'] ?>" alt="" style="max-width: 150px; max-height: 150px;"></div>
											</div>
											<div class="cart_item_name_container col-6 justify-content-center">
												<div class="cart_item_name"><a href="#"><?= $cartItem['name'] ?></a></div>
												<div class="cart_item_edit"><a href="#"><?= $cartItem['brand'] ?></a></div>
											</div>
										</div>

										<div class="cart_item_price col-1 justify-content-center text-center">$<?= formatPrice($cartItem['price']) ?></div>

										<div class="cart_item_quantity col-2 justify-content-center">
											<div class="product_quantity_container">
												<div class="product_quantity clearfix">
													<span>Qty</span>
													<input id="quantity_input-<?= $cartItem['id'] ?>" type="text" pattern="[0-9]*" value="<?= $cartItem['quantity'] ?>">
													<div class="quantity_buttons">
														<div class="quantity_inc quantity_control" id="item-<?= $cartItem['id'] ?>-inc"><i class="fa fa-chevron-up" aria-hidden="true"></i></div>
														<div class="quantity_dec quantity_control" id="item-<?= $cartItem['id'] ?>-dec"><i class="fa fa-chevron-down" aria-hidden="true"></i></div>
													</div>
												</div>
											</div>
										</div>

										<div class="cart_item_total col-1 text-center">$<span id="total-price-<?=$cartItem['id']?>"><?= formatPrice($cartItem['price'] * $cartItem['quantity']) ?></span>
											<i class="fa fa-trash fa-2x text-center text-danger" id="delete-<?= $cartItem['id'] ?>"></i>
										</div>
									</div>
								</div>



						<?php }
						} else { ?>
							<div class="text-dark mt-3 mb-5" style="font-size: 24px;">Nothing in the cart yet...</div>
						<?php } ?>



					</div>
				</div>

				<div class="row row_cart_buttons d-block">
					<div class="col">
						<div class="cart_buttons d-flex flex-lg-row flex-column align-items-start justify-content-start">
							<div class="button continue_shopping_button"><a href="#">Continue shopping</a></div>
							<div class="cart_buttons_right ml-lg-auto">
								<div class="button clear_cart_button"><a href="#">Clear cart</a></div>
								<div class="button update_cart_button"><a href="#">Update cart</a></div>
							</div>
						</div>
					</div>
				</div>

				<div class="row row_extra">
					<div class="col-lg-4">

						<div class="delivery">
							<div class="section_title">Shipping method</div>
							<div class="section_subtitle">Select the one you want</div>
							<div class="delivery_options">
								<label class="delivery_option clearfix">Next day delivery
									<input type="radio" name="radio">
									<span class="checkmark"></span>
									<span class="delivery_price">$4.99</span>
								</label>
								<label class="delivery_option clearfix">Standard delivery
									<input type="radio" name="radio">
									<span class="checkmark"></span>
									<span class="delivery_price">$1.99</span>
								</label>
								<label class="delivery_option clearfix">Personal pickup
									<input type="radio" checked name="radio">
									<span class="checkmark"></span>
									<span class="delivery_price">Free</span>
								</label>
							</div>
						</div>

						<div class="coupon">
							<div class="section_title">Coupon code</div>
							<div class="section_subtitle">Enter your coupon code</div>
							<div class="coupon_form_container">
								<form action="#" id="coupon_form" class="coupon_form">
									<input type="text" class="coupon_input" required>
									<button class="button coupon_button"><span>Apply</span></button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-6 offset-lg-2">
						<div class="cart_total">
							<div class="section_title">Cart total</div>
							<div class="section_subtitle">Final info</div>
							<div class="cart_total_container">
								<ul>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_total_title">Subtotal</div>
										<div class="cart_total_value cart-total ml-auto">$<?= $totalPrice ?></div>
									</li>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_total_title">Shipping</div>
										<div class="cart_total_value ml-auto">Free</div>
									</li>
									<li class="d-flex flex-row align-items-center justify-content-start">
										<div class="cart_total_title">Total</div>
										<div class="cart_total_value cart-total ml-auto">$<?= $totalPrice ?></div>
									</li>
								</ul>
							</div>
							<div class="button checkout_button"><a href="#">Proceed to checkout</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include(__DIR__ ."/../templates/_footer.php"); ?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<script>
		const quantityControls = document.querySelectorAll(".quantity_control");
		const deleteButtons = document.querySelectorAll(".fa-trash");

		function handleQuantity(e) {
			var action = e.target.id.split("-")[2]
			var itemId = e.target.id.split("-")[1]
			var quantityContainer = e.target.parentElement.previousElementSibling
			var currentQuantity = parseInt(quantityContainer.value);
			var newQuantity = action == "inc" ? ++currentQuantity : --currentQuantity;
			if (newQuantity <= 0) return false;

			updateQuantity(itemId, newQuantity);

			quantityContainer.value = newQuantity;
			var price = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.dataset.price;
			var totalPrice = parseFloat(price * newQuantity).toFixed(2);
			document.getElementById(`total-price-${itemId}`).innerText = `${totalPrice}`
			
			updateCartTotal();


		}

		function handleDelete(e) {
			itemId = e.target.id.split("-")[1]
			e.target.classList.remove("fa-trash");
			e.target.classList.add("fa-spinner");
			e.target.classList.add("fa-spin");

			deleteCartItem(itemId).then(() => {
				e.target.parentElement.parentElement.parentElement.remove();
			})


		}

		async function updateQuantity(itemId, newQuantity) {
			const res = await axios.post('/requestHandler', {
				id: itemId,
				quantity: newQuantity,
				action: "updateCartQuantity"
			});
		}

		async function deleteCartItem(itemId) {
			const res = await axios.post('/requestHandler', {
				id: itemId,
				action: "deleteCartItem",
				
			}).then((data) => {
				syncCartCount();
				updateCartTotal();
			});
		}

		async function syncCartCount() {
			await axios.post('/requestHandler', {
				action: "getCartCount"
			}).then(({data}) => {
				document.getElementById("cartCount").innerHTML = data;
			})
		}

		async function updateCartTotal() {
			await axios.post('/requestHandler', {
				action: "getCartTotal"
			}).then(({data}) => {
				document.querySelectorAll(".cart-total").forEach(i => i.innerHTML = `$${data}`);
			})
		}


		quantityControls.forEach(item => {
			item.addEventListener("click", handleQuantity)
		})

		deleteButtons.forEach(item => {
			item.addEventListener("click", handleDelete)
		})
	</script>
</body>

</html>