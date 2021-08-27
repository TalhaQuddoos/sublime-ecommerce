<!DOCTYPE html>
<html lang="en">

<head>
	<?php include(__DIR__ . "/../templates/_meta.php") ?>
	<?php include("__func__.php") ?>
	<title>Create Product</title>
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
	<link rel="stylesheet" href="/assets/css/style_main.css">

</head>

<body>
	<?php include(__DIR__ . "/../templates/_header.php") ?>
	<?php include(__DIR__ . "/../templates/_menu.php"); ?>
	
	<div class="container" style="margin-top:200px;">
		<h1 class="section_title text-dark">Create Product</h1>
		<form method="POST" action="/product/create" enctype="multipart/form-data">
			<div class="mb-3">
				<label class="form-label">Name</label>
				<input type="text" class="form-control text-dark" name="name">
			</div>

			<div class="mb-3">
				<label class="form-label">Brand</label>
				<input type="text" class="form-control text-dark" name="brand">
			</div>

			<div class="mb-3">
				<label class="form-label">Price</label>
				<input type="text" class="form-control text-dark" name="price">
			</div>

			<div class="mb-3">
				<label class="form-label">Category</label>
				<input type="text" class="form-control text-dark" name="category">
			</div>

			<div class="mb-3">
				<label class="form-label">Description</label>
				<textarea name="description" rows="10" name="description" class="form-control text-dark"></textarea>
			</div>

			<div class="mb-3">
				<label class="form-label">Thumbnail</label>
				<input type="file" class="form-control text-dark" name="thumbnail">
			</div>

			<div class="mb-3">
				<label class="form-label">Images</label>
				<input type="file" multiple class="form-control text-dark" name="images[]">
			</div>

			<button type="submit" class="btn btn-primary mb-5">Submit</button>

		</form>

		
	</div>
	<script src="/assets/js/jquery-3.2.1.min.js"></script>
	<script src="/assets/js/plugins_main.js"></script>
	<script src="/assets/js/pagespeed.js"></script>
</body>

</html>
