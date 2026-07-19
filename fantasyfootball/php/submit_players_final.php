<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
session_start();
$id = $_SESSION["userID"];
$sql1 = "INSERT INTO teamplayers (playerID, userID) SELECT playerID, userID FROM tempteam WHERE userID = $id"; 
$sql2 = "UPDATE userinfo SET teamComplete = \"True\" WHERE userID = $id"; 
$sql3 = "DELETE FROM tempteam WHERE userID = $id";
$db->get_con()->query($sql1);
$db->get_con()->query($sql2);
$db->get_con()->query($sql3);
 ?>
