<?php
require "config.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="ff.css" type="text/css">
    <link rel="stylesheet" href="table.css" type="text/css">
    <script> 
          var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myRecords = JSON.parse(this.responseText);
                var rows = "";
                for (i=0;i<myRecords.players.length;i++) {
                    var myRecord = myRecords.players[i];
                    var newRow = "<tr><td>"+myRecord.playerName+"</td><td>"+myRecord.nation+"</td><td>"+myRecord.position+"</td><td>"+myRecord.price+"</td><td>"+myRecord.playerPoints+"</td><td>"+myRecord.starter+"</td><tr>";
                    rows = rows+newRow;
                }
                document.getElementById("positionRows").innerHTML = rows; 
            }
        }
     function display_players_list()
        {
            xmlhttp.open("POST", "display_team.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("");
        }
    function reset_subs()
    {
        window.open('subs.php','_blank');
        xmlhttp.open("POST", "reset_subs.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("");
    }
        display_players_list();
  </script>
    </head>
<body>
<div class="main">
    <div class="table_container">
        <div class="main__content">
                        <h1> 
                            <?php
                            require_once __DIR__ . '/db_connect.php';
                            $db = new DB_CONNECT();
                             $id = $_SESSION["userID"];
                            $sql = "SELECT SUM(players.playerPoints) as total_points from teamplayers, players 
                            where players.playerID = teamplayers.playerID AND teamplayers.starter = 'True' AND teamplayers.userID =$id"; 
                            $result = $db->get_con()->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                // temp user array
                                $record = array();
                                $record["total_points"] = $row["total_points"];
                            }
                            echo("Team points:".$record["total_points"]);
                            ?>
                            </h1>
                <div class="mytabs">
                    <input type="radio" id="listTab" name="mytabs" checked="checked">
                        <label for="listTab">List </label>
                        <div class="tab">
                            <form method="POST" action="team_view.php">
                                <div class="table-wrapper">
                                    <table class ="player_table" border="1"  >
                                        <thead> 
                                            <td>Name </td>
                                            <td> Nation</td>
                                            <td> Position</td>
                                            <td>Price </td>
                                            <td>Points </td>
                                            <td> Starter </td>
                                        </thead>         
                                        <tbody id="positionRows">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    <input type="radio" id="gridTab" name="mytabs">
                        <label for="gridTab">Grid </label>
                        <div class="tab">
                            <div class="container">
                                <img src="images/pitch.PNG" alt="pitch" id="pitch_img">
                                <div class="goalkeeper_block">
                                            <?php require_once __DIR__ . '/db_connect.php';
                                            $db = new DB_CONNECT();
                                            $id = $_SESSION["userID"];
                                            $sql = "SELECT playerName, playerPoints FROM players, teamplayers where teamplayers.playerID = players.playerID and players.position = 'Goalkeeper'and teamplayers.userID=$id and teamplayers.starter = 'True'"; 
                                     $result = $db->get_con()->query($sql);
                                            $players = array();
                                            $points = array();
                                            while ($row = $result->fetch_assoc()) {
                                            $players[] = $row["playerName"];
                                            $points[] = $row["playerPoints"];
                                            }
                                                for ($i = 0; $i < count($players); $i++) {
                                                    echo "<input type='text' value='" . $players[$i]. ": " . $points[$i] . "'readonly>";
                                                 }    
                                            ?>           
                                </div>
                                <div class="defender_block">
                                        <?php require_once __DIR__ . '/db_connect.php';
                                            $db = new DB_CONNECT();
                                            $id = $_SESSION["userID"];
                                            $sql = "SELECT playerName, playerPoints FROM players, teamplayers where teamplayers.playerID = players.playerID and players.position = 'Defender' and teamplayers.userID=$id and teamplayers.starter = 'True'"; 
                                      $result = $db->get_con()->query($sql);
                                            $players = array();
                                            $points = array();
                                       while ($row = $result->fetch_assoc()) {
                                            $players[] = $row["playerName"];
                                            $points[] = $row["playerPoints"];
                                            }
                                                for ($i = 0; $i < count($players); $i++) {
                                                    echo "<input type='text' value='" . $players[$i]. ": " . $points[$i] . "'readonly>";
                                                          
                                            ?>     
                                </div>
                                <div class="midfielder_block">      
                                        <?php require_once __DIR__ . '/db_connect.php';
                                            $db = new DB_CONNECT();
                                            $id = $_SESSION["userID"];
                                            $sql = "SELECT playerName, playerPoints FROM players, teamplayers where teamplayers.playerID = players.playerID and players.position = 'Midfielder' and teamplayers.userID=$id and teamplayers.starter = 'True'"; 

                                            $result = $db->get_con()->query($sql);
                                            $players = array();
                                            $points = array();
                                            while ($row = $result->fetch_assoc()) {
                                            $players[] = $row["playerName"];
                                            $points[] = $row["playerPoints"];


                                            }
                                                for ($i = 0; $i < count($players); $i++) {
                                                    echo "<input type='text' value='" . $players[$i]. ": " . $points[$i] ."'readonly>";
                                                  }
                                        
                                            ?>
                                        
                                </div>
                                <div class="attacker_block">
                                    
                                        <?php require_once __DIR__ . '/db_connect.php';
                                            $db = new DB_CONNECT();
                                            $id = $_SESSION["userID"];
                                            $sql = "SELECT playerName, playerPoints FROM players, teamplayers where teamplayers.playerID = players.playerID and players.position = 'Attacker' and teamplayers.userID=$id and teamplayers.starter = 'True'"; 


                                            $result = $db->get_con()->query($sql);
                                           $players = array();
                                            $points = array();
                                            while ($row = $result->fetch_assoc()) {
                                            $players[] = $row["playerName"];
                                            $points[] = $row["playerPoints"];

                                            }
                                                for ($i = 0; $i < count($players); $i++) {
                                                    echo "<input type='text' id='playerBox' value='" . $players[$i]. ": " . $points[$i] . "'readonly>";
                                                  }
                                            ?>
                                </div>
                                    <div class="sub_block">
                                        
                                            <?php require_once __DIR__ . '/db_connect.php';
                                                $db = new DB_CONNECT();
                                                $id = $_SESSION["userID"];
                                                $sql = "SELECT playerName, playerPoints FROM players, teamplayers where teamplayers.playerID = players.playerID and teamplayers.userID=$id and teamplayers.starter = 'False'"; 
$result = $db->get_con()->query($sql);
 $players = array();
                                                $points = array();
                                            
                                                while ($row = $result->fetch_assoc()) {
                                                $players[] = $row["playerName"];
                                                $points[] = $row["playerPoints"]; }          
                                                    for ($i = 0; $i < count($players); $i++) {
                                                        echo "<input type='text' value='" . $players[$i]. ": " . $points[$i] . "'readonly>";
                                                    }
                                                      ?>
                                    </div>
                            </div>
                        </div>
                </div>
                <input type="button" class = "team_button5" onclick="reset_subs()" value="Make Changes"/>   
        </div>
    </div>
</div>

<div class="footer_container"></div>
</body>
</html>
