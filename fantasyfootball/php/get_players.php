<?php
$response = array();
// include db connect class
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
    session_start();
    $sql= "SELECT * FROM players";

    if (isset($_POST['position_box'])) {

        $search_position = $_POST['position_box'] ;
        $sql .= " WHERE position = '$search_position'";
    }
    if (isset($_POST['price_box'])) {
        $search_price = $_POST['price_box'] ;
        $sql .=" ORDER BY price $search_price";
    }
    if (isset($_POST['nation_box'])) {
        $search_nation = $_POST['nation_box'];
        $sql .=" WHERE nation LIKE '$search_nation'";
    }
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
        // push single record into final response array
        array_push($response["players"], $record);
    }
    // success
    $response["success"] = 1;
    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "No records found";
    echo json_encode($response);
}
?>
