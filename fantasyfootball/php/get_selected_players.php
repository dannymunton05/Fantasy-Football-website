<?php
// array for JSON response
$response = array();
// include db connect class
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
    session_start();
    $id = $_SESSION["userID"];
    $sql= "SELECT * FROM players INNER JOIN tempteam ON players.playerID = tempteam.playerID WHERE userID = $id";
$result = $db->get_con()->query($sql);
// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["players"] = array();
    while ($row = $result->fetch_assoc()) {
        // temp user array
        $record = array();
        $record["playerID"] = $row["playerID"];
        $record["playerName"] = $row["playerName"];
        $record["nation"] = $row["nation"];
        $record["position"] = $row["position"];
        $record["price"] = $row["price"];

        // push single record into final response array
        array_push($response["players"], $record);
    }
    // success
    $response["success"] = 1;


    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";


    // echo no users JSON
    echo json_encode($response);
}
?>
