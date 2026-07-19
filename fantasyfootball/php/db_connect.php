<?php
class DB_CONNECT {
    private $con;
    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }
    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }
    function connect() {
        // import database connection variables
        require_once __DIR__ . '/config.php';
        // Connecting to mysql database
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
        // Checking connection to the database
        if ($this->con->connect_error) {
            die("Failed to connect to MySQL: ".$this->con->connect_error);
        };
    }
    function get_con() {
        // returning connection cursor
        return $this->con;
    }
    function close() {
        $this->con->close();
    }
}
?>
