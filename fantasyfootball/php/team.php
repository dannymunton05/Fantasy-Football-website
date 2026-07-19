<?php 
require "config.php";
session_start();
// Check if the user has already created a team, if yes direct them to team view page
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
$id = $_SESSION["userID"];
$sql = "SELECT teamComplete FROM userinfo WHERE userID = $id"; 
$result = $db->get_con()->query($sql);
while ($row = $result->fetch_assoc()) {
$record = array();
 $record["teamComplete"] = $row["teamComplete"];
}
if($record["teamComplete"] == 'True')
{
    header("location: team_view.php");
    exit;
}
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
                    var newRow = "<tr><td>"+myRecord.playerName+"</td><td>"+myRecord.nation+"</td><td>"+myRecord.position+"</td><td>"+myRecord.price+"</td><td><input type=\"checkbox\" value=\""+myRecord.playerID+"\"name=\"check_list1\"/></td><tr>";
                    rows = rows+newRow;
                }
                document.getElementById("positionRows").innerHTML = rows;
            }
        }
        function submit_filter(choice)
        {
            let postData="";
            if (choice==1)
            {
                postData="position_box="+document.getElementById("positions").value;
                document.getElementById("positions").value = "";
            } else if (choice==2)
            {
               postData="price_box="+document.getElementById("prices").value;
                document.getElementById("prices").value = "";
            } else if (choice==3)
            {
            postData="nation_box="+document.getElementById("nations").value;
                document.getElementById("nations").value = "";
            }
 xmlhttp.open("POST", "get_players.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send(postData);
        }
        function reset_players()
        {
            xmlhttp.open("POST", "get_players.php", true);
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
        function submit_players()
        {
            ids = get_checked_id("check_list1");
            xmlhttp.open("POST", "submit_players.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("player_ids="+ids);
        }
        function open_confirmation()
        {
            window.location.href = "team_confirmation.php";
        }
        function submit_temp_players()
        {
            submit_players();
            location.reload();
        }
        reset_players();
 </script>       
</head>
<body>
    <!-- Main section -->
<div class="main">
    <div class="table_container">
        <div class="main__content">
            <h3> Please select your team</h3>
            <h4> You must select 2 GOALKEEPERS, 5 DEFENDERS, 5 MIDFIELDERS and 3 ATTACKERS </h4>
            <h2> Budget = £100m </h2>
                <div class="search_container">
                    <form name = "search_position">
                        <label> Position:
                            <input list="position_list" name ="position_box" id="positions"/>
                        </label>
                        <datalist id="position_list">
                            <option value="">ANY</option>
                            <option value="Goalkeeper">GK</option>
                            <option value="Defender">DEF</option>
                            <option value="Midfielder">Midfielder</option>
                            <option value="Attacker">ATT</option>
                        </datalist> 
                        <input type="button" onClick="submit_filter(1)" value="Submit">
                    </form>
                    <form name = "search_price" method = "POST" action = "get_players.php">
                        <label> Price:
                            <input list="price_list" name ="price_box" id="prices"/>
                        </label>
                        <datalist id="price_list">
                        <option value="">Sort by</option>
                        <option value="ASC">Low to high</option>
                        <option value="DESC">High to low</option>
                        </datalist> 
                        <input type="button" onClick="submit_filter(2)" value="Submit">
                    </form>
                    <form name = "search_nation" method = "POST" action = "get_players.php">
                        Nation: <input type="text" name = "nation_box" id="nations">
                        <input type="button" onClick="submit_filter(3)" value="Submit">
                    </form>
                </div>
            <form method="POST" action="team.php">
                <div class="table-wrapper">
                    <table class ="player_table" border="1"  >
                        <thead> 
                            <td><strong>Name </td><td><strong>Nation</td>
                            <td><strong> Position</td>
                            <td><strong>Price </td>
                           <td>Select</td>
                        </thead>      
                        <tbody id="positionRows">
                        </tbody>
                    </table>
                </div>
                        <input type="button" class = "team_button1" onclick="reset_players()" value="Reset"/>
                        <input type="button" class = "team_button2" onclick="submit_temp_players()" value="Add" /> 
                        <input type="button" class = "team_button4" onclick="open_confirmation()" value="Review" />         
            </form>
        </div>  
    </div>
</div>
 <div class="footer_container">
    </div>
</html>

