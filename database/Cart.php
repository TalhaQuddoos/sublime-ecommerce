<?php

class Cart
{
    public $db;
    public $Product;

    public function __construct($db, $Product)
    {
        $this->db = $db;
        $this->Product = $Product;
    }

    public function getCartItems()
    {
        $user_id = $_SESSION['user'];
        $query = $this->db->con->prepare("SELECT * FROM cart WHERE user_id=?");
        $query->bind_param("i", $user_id);
        $query->execute();

        $results = $query->get_result();

        if ($results->num_rows > 0) {
            $results = $this->db->resultSetToArray($results);
            $cartItems = [];
            foreach ($results as $result) {
                $product = $this->Product->getProduct($result['product_id']);
                $cartItem = [
                    'id' => $result['cart_id'],
                    'name' => $product['product_name'],
                    'thumbnail' => $product['product_thumbnail'],
                    'price' => $product['product_price'],
                    'brand' => $product['product_brand'],
                    'quantity' => $result['quantity']
                ];
                $cartItems[] = $cartItem;
            }

            return $cartItems;
        }


        return [];
    }

    function addToCart($productId, $quantity)
    {
        $userId = $_SESSION["user"];
        $query = $this->db->con->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $query->bind_param("iii", $userId, $productId, $quantity);
        $query->execute();
        return $this->db->con->insert_id;
    }

    public function updateQuantity($id, $quantity)
    {
        $query = $this->db->con->prepare("UPDATE cart SET quantity=? WHERE cart_id=?");
        $query->bind_param("ii", $quantity, $id);
        return $query->execute();
    }

    public function checkInCart($productId)
    {
        $userId = $_SESSION["user"];

        $query = $this->db->con->prepare("SELECT * FROM cart WHERE user_id=? AND product_id=?");
        $query->bind_param("ii", $userId, $productId);
        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            return [$result['cart_id'], $result['quantity']];
        }

        return false;
    }

    public function deleteItem($id)
    {
        $query = $this->db->con->prepare("DELETE FROM cart WHERE cart_id=?");
        $query->bind_param("i", $id);
        return $query->execute();
    }

    public function getCartCount()
    {
        if (!isset($_SESSION['user']))  return 0;
        $userId = $_SESSION['user'];
        $query = $this->db->con->prepare("SELECT * FROM cart WHERE user_id=?");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->get_result();
        return $result->num_rows;
    }

    public function getCartTotal()
    {
        $cartItems = $this->getCartItems();
        $totalPrice = array_sum(array_map(function ($a, $b) {
            return $a * $b;
        }, array_column($cartItems, 'price'), array_column($cartItems, 'quantity')));
        return $totalPrice;

    }
}
