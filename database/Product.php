<?php

require_once("Cloudinary.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class Product
{
    public $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM product";
        $results = $this->db->con->query($query);
        $products = $this->db->resultSetToArray($results);
        return $this->parseProducts($products);
    }

    public function getProduct($id)
    {
        $result = $this->db->con->query("SELECT * FROM product WHERE product_id=$id");
        $product = $this->db->resultSetToArray($result)[0] ?? null;
        if ($product) {
            $product['product_images'] = $this->db->parseJSON($product['product_images']);
            return $product;
        }

        return null;
    }

    public function getProducts($category = null, $brand = null, $limit = null, $page = null, $price_gt = null, $price_lt = null, $search_query = null, $order = null)
    {
        $sql = "SELECT * FROM product";
        $where = [];

        $params = [];
        $paramTypes = "";

        if ($category) {
            $where[] = "product_category=?";
            $paramTypes .= "s";
            $params[] = $category;
        }

        if ($price_gt) {
            $where[] = "product_price >= ?";
            $paramTypes .= "d";
            $params[] = $price_gt;
        }

        if ($price_lt) {
            $where[] = "product_price <= ?";
            $paramTypes .= "d";
            $params[] = $price_lt;
        }

        if ($brand) {
            $where[] = "product_brand = ?";
            $paramTypes .= "s";
            $params[] = $brand;
        }

        if ($search_query) {
            $where[] = "MATCH (product_name, product_brand, product_category) AGAINST (?)";
            $paramTypes .= "s";
            $params[] = $search_query;
        }

        if (count($where) > 0) {
            $sql .= " WHERE ";
            $sql .= implode(" AND ", $where);
        } 

        if ($order) {
            $sql .= " ORDER BY product_price";
            if ($order[0] == '-') $sql .= " DESC";
        }


        if ($limit || $page) {

            if ($limit && !$page) {
                $page = 1;
            }

            if ($page && !$limit) {
                $limit = 20;
            }

            $sql .= " LIMIT ?, ?";
            $limit_start = ($limit * $page) - $limit + 1;
            $limit_end = $limit * $page;

            array_push($params, $limit_start, $limit_end);
            $paramTypes .= "ii";
        }



        if($sql == "SELECT * FROM product") {
            return $this->getRandomProducts(20);
        }

        $query = $this->db->con->prepare($sql);
        if(strlen($paramTypes) > 0)
            $query->bind_param($paramTypes, ...$params);
        $query->execute();

        $results = $this->db->resultSetToArray($query->get_result());

        if ($search_query && count($results) == 0) {
            return null;
        }

        $products = $this->parseProducts($results);

        return $products;
    }

    public function getRandomProducts($num, $category = null, $exclude = 0)
    {
        if ($category) {
            $query = $this->db->con->prepare("SELECT * FROM product WHERE product_category=? AND product_id<>? ORDER BY RAND() LIMIT ?");
            $query->bind_param("sii", $category, $exclude, $num);
        } else {
            $query = $this->db->con->prepare("SELECT * FROM product ORDER BY RAND() LIMIT ?");
            $query->bind_param("i", $num);
        }

        $query->execute();
        $results = $query->get_result();
        $products = $this->db->resultSetToArray($results);
        return $this->parseProducts($products);
    }

    public function getAllCategories()
    {
        $query = "SELECT DISTINCT product_category FROM product";
        $results = $this->db->con->query($query);
        return $this->db->resultSetToArray($results);
    }

    public function getAllBrands()
    {
        $query = "SELECT DISTINCT product_brand FROM product";
        $results = $this->db->con->query($query);
        return $this->db->resultSetToArray($results);
    }

    public function createProduct()
    {


        $cloudinary = new Cloudinary();
        $imageUrls = $cloudinary->uploadImages($_FILES['images']);
        $images = json_encode($imageUrls);
        $thumbnail = $cloudinary->upload($_FILES['thumbnail']['tmp_name'], $_FILES['thumbnail']['type']);

        $data = [
            "product_name" => $_POST['name'],
            "product_brand" => $_POST['brand'],
            "product_price" => $_POST['price'],
            "product_category" => $_POST['category'],
            "product_description" => $_POST['description'],
            "product_images" => "$images",
            "product_thumbnail" => $thumbnail,
            "product_reviews" => "\"[]\""
        ];

        $columns = implode(",", array_keys($data));

        $query = $this->db->con->prepare("INSERT INTO product ($columns) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("ssdsssss", ...array_values($data));
        $query->execute();

        return $this->db->con->insert_id;
    }



    public function parseProducts($products)
    {
        for ($i = 0; $i < count($products); $i++) {
            $images = $this->db->parseJSON($products[$i]['product_images']);
            $products[$i]["product_images"] = $images;
        }
        return $products;
    }
}
