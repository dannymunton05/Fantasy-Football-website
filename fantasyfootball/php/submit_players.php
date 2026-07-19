<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
session_start();
if(isset($_POST['player_ids']))  
{
    $player_check=$_POST['player_ids'];  
    $players = explode(",", $player_check);
    $check = "";
    foreach($players as $player)  
    {  
        $check .=  "(" . $player . "," . $_SESSION["userID"] . "),";
    } 
    $check = substr($check,0,-1);
    $sql = "INSERT INTO tempteam (playerID,userID) VALUES $check"
    $db->get_con()->query($sql);
} 
