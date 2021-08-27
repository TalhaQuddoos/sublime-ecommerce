<?php


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


class Auth {

    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login() {
        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";
        $query = $this->db->con->prepare("SELECT * FROM user WHERE user_username=? AND user_password=?");
        $query->bind_param("ss", $username, $password);
        $query->execute();
        $res = $query->get_result();
        $user = $res->fetch_assoc();

        if($user != null) {
            $_SESSION['user'] = $user['user_id'];
            return true;
        }

        return false;

    }

    public function register() {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = $this->db->con->prepare("INSERT INTO user (user_username, user_name, user_password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $username, $name, $password);
        return $query->execute();
    }

    public function isLoggedIn() {
        return isset($_SESSION["user"]);
    }
}
