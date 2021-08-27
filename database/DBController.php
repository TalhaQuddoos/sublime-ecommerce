<?php

require_once("DotEnv.php");

(new DotEnv(__DIR__ . '/../.env'))->load();

class DBController
{
    // protected $host = getenv("DATABASE_USERNAME");
    // protected $username = "root";
    // protected $password = "";
    // protected $database = "eshop";
    protected $host, $username, $password, $database;

    public $con = null;

    public function __construct()
    {
        $this->host = getenv("DATABASE_HOST");
        $this->username = getenv("DATABASE_USERNAME");
        $this->password = getenv("DATABASE_PASSWORD");
        $this->database = getenv("DATABASE_DBNAME");
        $this->con = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->con->connect_error) {
            echo "Error: " . $this->con->connect_error;
        }
    }

    public function resultSetToArray($result)
    {
        $arr = [];

        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        return $arr;
    }

    public function parseJSON($json_string)
    {
        $json = json_decode($json_string, true);
        if (is_string($json)) {
            $json = json_decode($json, false);
        }
        return $json;
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    public function closeConnection()
    {
        if ($this->con != null) {
            $this->con->close();
            $this->con = null;
        }
    }
}

?>




