<?php
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
session_start();
$id = $_SESSION["userID"];
$sql = "DELETE FROM tempteam WHERE userID = $id";
$db->get_con()->query($sql);
?>
