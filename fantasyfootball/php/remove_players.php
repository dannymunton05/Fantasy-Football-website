<?php
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
session_start();
if(isset($_POST['player_ids']))
{
    $player_check=$_POST['player_ids'];  
    $players = explode(",", $player_check);
    $check = "";
    foreach($players as $player)  
    {  
        $check .=  $player . ",";
    } 
    $check = substr($check,0,-1);
    $id = $_SESSION["userID"];
    $sql = "DELETE FROM tempteam WHERE userID = $id AND playerID IN ($check)";
    $db->get_con()->query($sql);
}
?>
