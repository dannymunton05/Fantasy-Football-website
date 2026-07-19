<?php
$response = array();
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
    session_start();
    $id = $_SESSION["userID"];
    $sql= "SELECT * FROM players left join teamplayers using (playerID) where userID = $id";
$result = $db->get_con()->query($sql);
if ($result->num_rows > 0) {
    $response["players"] = array();
    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["playerID"] = $row["playerID"];
        $record["playerName"] = $row["playerName"];
        $record["nation"] = $row["nation"];
        $record["position"] = $row["position"];
        $record["price"] = $row["price"];
        $record["playerPoints"] = $row["playerPoints"];
        $record["starter"] = $row["starter"];
        array_push($response["players"], $record);
    }
    $response["success"] = 1;
    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "No records found";
    echo json_encode($response);
}
?>
