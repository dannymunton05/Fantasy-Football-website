<?php
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
session_start();
$id = $_SESSION["userID"];
$response["teamcheck"] = array();
    $sql = "SELECT SUM(players.price) as total_price from tempteam, players
    where players.playerID = tempteam.playerID AND tempteam.userID =$id"; 
    $result = $db->get_con()->query($sql);
    if ($result->num_rows > 0) {
        // looping through all results
        
    
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["total_price"] = $row["total_price"];
        }    
        // push single record into final response array
        array_push($response["teamcheck"], $record);
    }
    $sql = "SELECT count(tempteam.playerID) as attackers from tempteam, players
    where tempteam.playerID = players.playerID and players.position = 'Attacker' and tempteam.userID=$id"; 
    $result = $db->get_con()->query($sql);
    if ($result->num_rows > 0) {
        // looping through all result
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["attackers"] = $row["attackers"];
        }  
        // push single record into final response array
        array_push($response["teamcheck"], $record);
    }
    $sql = "SELECT count(tempteam.playerID) as midfielders from tempteam, players 
    where tempteam.playerID = players.playerID and players.position = 'Midfielder' and tempteam.userID=$id"; 
    $result = $db->get_con()->query($sql);
    if ($result->num_rows > 0) {
        // looping through all results
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["midfielders"] = $row["midfielders"];
        }
        // push single record into final response array
        array_push($response["teamcheck"], $record);
    }
    $sql = "SELECT count(tempteam.playerID) as defenders from tempteam, players 
    where tempteam.playerID = players.playerID and players.position = 'Defender' and tempteam.userID=$id";
    $result = $db->get_con()->query($sql);
    if ($result->num_rows > 0) {
        // looping through all results
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["defenders"] = $row["defenders"];
        } 
        // push single record into final response array
        array_push($response["teamcheck"], $record);
    }
    $sql = "SELECT count(tempteam.playerID) as goalkeepers from tempteam, players where tempteam.playerID = players.playerID and players.position = 'Goalkeeper' and tempteam.userID=$id"; 
    $result = $db->get_con()->query($sql);
    if ($result->num_rows > 0) {
        // looping through all results
        while ($row = $result->fetch_assoc()) {
            // temp user array
            $record = array();
            $record["goalkeepers"] = $row["goalkeepers"];
        
        // push single record into final response array
        array_push($response["teamcheck"], $record);
    }
    echo json_encode($response);
    ?>
