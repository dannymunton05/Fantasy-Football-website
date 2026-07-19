<?php
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
$sql = "UPDATE teamplayers SET starter = 'False'";
$db->get_con()->query($sql);
?>


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
                    var newRow = "<tr><td>"+myRecord.playerName+"</td><td>"+myRecord.nation+"</td><td>"+myRecord.position+"</td><td>"+myRecord.price+"</td><td>"+myRecord.playerPoints+"</td><td><input type=\"checkbox\"  value=\""+myRecord.playerID+"\" name=\"check_list\"/></td><tr>";
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
        function get_checked_id(checkboxName) 
        {
            var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked');
            values = [];
            Array.prototype.forEach.call(checkboxes, function(id)
            {
                values.push(id.value);
            });
            return values;
        }
        function chooseStarters()
        {
             ids = get_checked_id("check_list");
             count = ids.length;
             goalkeepers = <?php
                require_once __DIR__ . '/db_connect.php';
                $db = new DB_CONNECT();
                $id = $_SESSION["userID"];
                $sql = "SELECT count(tempteam.playerID) as goalkeepers from tempteam, players
                where tempteam.playerID = players.playerID and players.position = 'Goalkeeper' and tempteam.userID=$id";
                $result = $db->get_con()->query($sql);
                echo($result);
                ?>
            if(count == 11 && goalkeepers > 1)
            {
               xmlhttp.open("POST", "substitutions.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("player_ids="+ids);
                alert("Changes Saved");
            }
            else 
            {
                alert("Error, you must have 11 players in your starting lineup. You have " +count);
           }
        }
        display_players_list();
  </script>
    </head>
<body> 
    <div class="main__content">
        <h1> Choose your starting 11:</h1>
        <h2> Substitutions are active!</h2>
        <form method="POST" action="team_view.php">
            <div class="table-wrapper">
                <table class ="player_table" border="1"  >
                    <thead>  
   <td>Name </td><td> Nation</td><td> Position</td><td>Price </td><td>Points </td> <td> Starter </td>
                    </thead>      
                    <tbody id="positionRows">
                    </tbody>
                </table>
            </div>
            <input type="button" class = "team_button1" onclick="chooseStarters()" value="Save"/>
        </form>
    </div>
</body>
