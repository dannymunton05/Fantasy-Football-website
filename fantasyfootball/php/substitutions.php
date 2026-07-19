<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
session_start();
$id = $_SESSION["userID"]; 
if(isset($_POST['player_ids']))  
{
    $player_check=$_POST['player_ids'];  
    $players = explode(",", $player_check);
    $check = "";
    foreach($players as $player)  
    {  
        $check .=  "playerID = ".$player." OR ";
    } 
    $check = substr($check,0,-4);
    $sql = "UPDATE teamplayers SET starter = 'True' WHERE $check AND userID = $id";
    $db->get_con()->query($sql);
}
