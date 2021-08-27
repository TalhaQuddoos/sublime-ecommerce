<?php

include("__func__.php");

$category = $_GET['category'] ?? null;
$brand = $_GET['brand'] ?? null;
$price_lt = $_GET['price_lt'] ?? null;
$price_gt = $_GET['price_gt'] ?? null;
$page = $_GET['page'] ?? null;
$limit = $_GET['limit'] ?? null;
$search_query = $_GET['search_query'] ?? null;
$order = $_GET['order'] ?? null;

$products_match = true;
$products = $Product->getProducts($category, $brand, $limit, $page, $price_gt, $price_lt, $search_query, $order);

if (!$products) {
    $products = $Product->getRandomProducts(8);
    $products_match = false;
}

$categories = $Product->getAllCategories();
$brands = $Product->getAllBrands();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
    <?php include(__DIR__ . "/../templates/_meta.php"); ?>
    <link rel="stylesheet" href="/assets/css/categories.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="super_container">
        <?php include(__DIR__ . "/../templates/_header.php"); ?>
        <?php include(__DIR__ . "/../templates/_menu.php"); ?>
        <?php if (!$products_match) { ?>
            <div class="home" style="height: 300px;">
                <div class="home_container">
                    <div class="home_content_container">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="home_content w-100">
                                        <div class="home_title text-dark">No Products Found<span>.</span></div>
                                        <div class="home_text">
                                            <p class="text-dark" style="font-size: 20px;">Please try using a different search phrase.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>

            <div class="home" style="height: 400px;">
                <div class="home_container">
                    <div class="home_background" style="background-image:url(assets/images/categories.jpg)"></div>
                    <div class="home_content_container">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="home_content">
                                        <div class="home_title">Browse <?php echo $category ? (ucwords($category) . "s") : "Products"  ?><span>.</span></div>
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
        <?php } ?>

        <div class="container mt-5 col-11">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" name="search_query">
                    <button class="btn btn-success" type="button" onclick="document.getElementById('searchSubmitButton').click()"><i class="fa fa-search"></i></button>
                    <button class="btn btn-outline-success" type="button" onclick="document.getElementById('filterButton').click()"><i class="fa fa-cogs"></i></button>
                    <input type="submit" id="searchSubmitButton" hidden>
                </div>
            </form>


        </div>

        <button type="button" class="btn btn-primary d-none" id="filterButton" data-bs-toggle="modal" data-bs-target="#filterModal"></button>

        <!-- Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="font-family: 'Poppins';">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-size: 24px; font-family: 'Poppins'" id="exampleModalLabel">Advanced Search</h5>
                        <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></span>
                    </div>
                    <div class="modal-body">
                        <form>
                            <label class="form-label text-muted" style="font-size: 14px; margin-bottom: 5px;">Search Query</label>
                            <input type="text" class="form-control" name="search_query" value="<?= $search_query ?>">

                            <label class="form-label text-muted mt-3" style="font-size: 14px; margin-bottom: 5px;">Category</label>
                            <select name="category" id="" class="form-control">
                                <option value="">Any</option>
                                <?php foreach ($categories as $category) {
                                    $selected = isset($_GET['category']) ? (($_GET['category'] == $category['product_category']) ? "selected" : "") : "";
                                ?>

                                    <option value="<?= $category['product_category'] ?>" <?= $selected ?>><?= ucwords($category['product_category']) ?></option>
                                <?php } ?>
                            </select>

                            <label class="form-label text-muted mt-3" style="font-size: 14px; margin-bottom: 5px;">Brand</label>
                            <select name="brand" id="" class="form-control">
                                <option value="">Any</option>
                                <?php foreach ($brands as $brand) {
                                    $selected = isset($_GET['brand']) ? ((strtolower($_GET['brand']) == strtolower($brand['product_brand'])) ? "selected" : "") : "";
                                ?>

                                    <option value="<?= strtolower($brand['product_brand']) ?>" <?= $selected ?>><?= ucwords($brand['product_brand']) ?></option>
                                <?php } ?>
                            </select>

                            <label class="form-label text-muted mt-3" style="font-size: 14px; margin-bottom: 5px;">Price</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Min" name="price_gt" value="<?= $price_gt ?>">
                                <input type="text" class="form-control" placeholder="Max" name="price_lt" value="<?= $price_lt ?>">
                            </div>

                            <input type="submit" hidden id="filterSubmitButton">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-outline-danger">Clear all filters</button> -->
                        <button type="button" class="btn btn-success" onclick="document.getElementById('filterSubmitButton').click()">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="products mt-5 mb-5">
            <div class="container" style="margin-top: 150px;">
                <div class="row justify-content-center">
                    <div class="col-11">


                        <div class="product_grid row justify-content-start">
                            <?php foreach ($products as $product) : ?>
                                <div class="product col-lg-3 col-md-4 col-sm-6 col-6" style="height: 300px;">
                                    <div class="product_image text-center"><img src="<?= $product['product_thumbnail'] ?>"></div>
                                    <div class="product_content">
                                        <div class="product_title"><a href="/product?id=<?= $product['product_id'] ?>" style="max-height: 100px;" class="text-truncate d-block"><?= $product['product_name'] ?></a></div>
                                        <div class="product_price">$<?= $product['product_price'] ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>





                        <!-- <div class="product_pagination">
                            <ul>
                                <li class="active"><a href="#">01.</a></li>
                                <li><a href="#">02.</a></li>
                                <li><a href="#">03.</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <?php include(__DIR__ . "/../templates/_footer.php"); ?>
    </div>
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/assets/js/plugins_main.js"></script>
    <script src="/assets/js/pagespeed.js"></script>
</body>

</html>