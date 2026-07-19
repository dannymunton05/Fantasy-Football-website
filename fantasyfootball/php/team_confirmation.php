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
                    var newRow = "<tr><td>"+myRecord.playerName+"</td><td>"+myRecord.nation+"</td><td>"+myRecord.position+"</td><td>"+myRecord.price+"</td><td><input type=\"checkbox\" value=\""+myRecord.playerID+"\" name=\"check_list\"/></td><tr>";
                    rows = rows+newRow;
                }
                document.getElementById("positionRows").innerHTML = rows;
            }
        }
     function display_players()
        {
            xmlhttp.open("POST", "get_selected_players.php", true);
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
      function remove_players()
      {
        ids = get_checked_id("check_list");
            xmlhttp.open("POST", "remove_players.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("player_ids="+ids);
      }
      function remove_temp_players()
      {
        remove_players();
        location.reload();
      }
      var xmlhttpSubmit = new XMLHttpRequest();
      xmlhttpSubmit.onreadystatechange = function() 
      {
            if (this.readyState == 4 && this.status == 200)
             {
                var requirements = this.responseText;
                var myPlayers = JSON.parse(requirements);
                var price = myPlayers.teamcheck[0];
                var attackers = myPlayers.teamcheck[1];
                var midfielders = myPlayers.teamcheck[2];
                var defenders = myPlayers.teamcheck[3];
                var goalkeepers = myPlayers.teamcheck[4];
                if (price.total_price <=100 && attackers.attackers == 3 && midfielders.midfielders == 5
                    && defenders.defenders == 5 && goalkeepers.goalkeepers == 2)
                {
                    submit();
                }
               else
                  {
                    var errorMessage = "";
                     
                    if (price.total_price > 100)
                    {
                        errorMessage+= "ERROR - Must be within 100m budget. Your team is valued at: " + price.total_price +"\n";
                    }
                    if (attackers.attackers != 3)
                    {
                        errorMessage += "ERROR - You must select 3 attackers. You currently have " +attackers.attackers+"\n";
                    }
                    if (midfielders.midfielders != 5)
                    {
                        errorMessage += "ERROR - You must select 5 midfielders. You currently have " +midfielders.midfielders+"\n";
                    }
                    if (defenders.defenders != 5)
                    {
                        errorMessage += "ERROR - You must select 5 defenders. You currently have " +defenders.defenders+"\n";
                    }
                    if (goalkeepers.goalkeepers != 2)
                    {
                        errorMessage += "ERROR - You must select 2 goalkeepers. You currently have " +goalkeepers.goalkeepers+"\n";
                    }
                  alert(errorMessage);
                }
                errorMessage = "";
           }
      }
      function submit_players_check()
      {
        xmlhttpSubmit.open("POST", "submit_players_check.php", true);
        xmlhttpSubmit.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttpSubmit.send("");
      }
      function submit()
      {
        xmlhttpSubmit.open("POST", "submit_players_final.php", true);
        xmlhttpSubmit.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttpSubmit.send("");
        window.location.href = "team_view.php";
      }
        display_players();
</script>
    </head>
<body>
    <?php
    require_once __DIR__ . '/db_connect.php';
   $db = new DB_CONNECT();
   $id = $_SESSION["userID"];
   $sql = "SELECT SUM(players.price) as total_price from tempteam, players where players.playerID = tempteam.playerID AND tempteam.userID =$id"; 
  $result = $db->get_con()->query($sql);
  while ($row = $result->fetch_assoc()) {
    // temp user array
    $record = array();
    $record["total_price"] = $row["total_price"];
}
echo("Squad Value:".$record["total_price"]." /100");
   ?>
    <form method="POST" action="team_confirmation.php">
<div class="table-wrapper">
    <table class ="player_table" border="1"  >
        <thead> 
            <td>Name </td>
            <td>  Nation</td>
            <td> Position</td>
            <td>Price </td>
            <td> Remove </td>
        </thead>      
        <tbody id="positionRows">
        </tbody>
    </table>
</div>
    <div class="confirm_button">
        <input type="button" class="team_button2" name="player_ids" onclick="submit_players_check()"  value="Submit" />  
        <input type="button" class="team_button1" name="player_ids" onclick="location.href = 'team.php'"  value="Back" />
        <input type="button" class="team_button3" name="player_ids" onclick="remove_temp_players()"  value="Remove" /> 
    </div>             
</form>

</form>
<div class="footer_container"></div>
</body>
</html>
