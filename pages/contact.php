<!DOCTYPE html>
<html lang="en">

<head>
	<title>Contact</title>
	<?php include(__DIR__ ."/../templates/_meta.php"); ?>
	<?php include(__DIR__ ."/__func__.php"); ?>
	<link rel="stylesheet" type="text/css" href="/assets/css/contact.css" />
</head>

<body>
	<div class="super_container">
		<?php include(__DIR__ ."/../templates/_header.php"); ?>
		<?php include(__DIR__ ."/../templates/_menu.php"); ?>

		<div class="contact">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 contact_col">
						<div class="get_in_touch">
							<div class="section_title mt-5" style="font-size: 36px;">Get in Touch</div>
							<div class="contact_form_container">
								<form action="#" id="contact_form" class="contact_form">
									<div class="row">
										<div class="col-xl-6">

											<label for="contact_name">First Name*</label>
											<input type="text" id="contact_name" class="contact_input" required>
										</div>
										<div class="col-xl-6 last_name_col">

											<label for="contact_last_name">Last Name*</label>
											<input type="text" id="contact_last_name" class="contact_input" required>
										</div>
									</div>
									<div>

										<label for="contact_company">Subject</label>
										<input type="text" id="contact_company" class="contact_input">
									</div>
									<div>
										<label for="contact_textarea">Message*</label>
										<textarea id="contact_textarea" class="contact_input contact_textarea" required></textarea>
									</div>
									<button class="button contact_button"><span>Send Message</span></button>
								</form>
							</div>
						</div>
					</div>

					<!-- <div class="col-lg-3 offset-xl-1 contact_col">
						<div class="contact_info">
							<div class="contact_info_section">
								<div class="contact_info_title">Marketing</div>
								<ul>
									<li>Phone: <span>+53 345 7953 3245</span></li>
									<li>Email: <span><a href="https://preview.colorlib.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f0899f85829d91999cb0979d91999cde939f9d">[email&#160;protected]</a></span>
									</li>
								</ul>
							</div>
							<div class="contact_info_section">
								<div class="contact_info_title">Shippiing & Returns</div>
								<ul>
									<li>Phone: <span>+53 345 7953 3245</span></li>
									<li>Email: <span><a href="https://preview.colorlib.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a1d8ced4d3ccc0c8cde1c6ccc0c8cd8fc2cecc">[email&#160;protected]</a></span>
									</li>
								</ul>
							</div>
							<div class="contact_info_section">
								<div class="contact_info_title">Information</div>
								<ul>
									<li>Phone: <span>+53 345 7953 3245</span></li>
									<li>Email: <span><a href="https://preview.colorlib.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="41382e34332c20282d01262c20282d6f222e2c">[email&#160;protected]</a></span>
									</li>
								</ul>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>

		<?php include(__DIR__ ."/../templates/_footer.php") ?>
		
	</div>

	<script src="/assets/js/jquery-3.2.1.min.js"></script>
	<script src="/assets/js/pagespeed.js"></script>

</html>