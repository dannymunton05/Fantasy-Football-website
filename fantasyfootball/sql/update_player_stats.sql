INSERT INTO playerstats1 (playerName) SELECT playerName FROM tempstats1 WHERE NOT EXISTS (SELECT 1 FROM playerstats1 WHERE playerstats1.playerName = tempstats1.playerName)
UPDATE playerstats1 SET goals = goals + (SELECT tempstats1.goals FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName), 
assists = assists + (SELECT tempstats1.assists FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName), cleanSheets = cleanSheets + (SELECT tempstats1.cleanSheets FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName), played = played + (SELECT tempstats1.played FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName), sixtyMins = sixtyMins + (SELECT tempstats1.sixtyMins FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName), yCard = yCard + (SELECT tempstats1.yCard FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName), rCard = rCard + (SELECT tempstats1.rCard FROM tempstats1 WHERE tempstats1.playerName = playerstats1.playerName);
UPDATE players SET playerPoints = (SELECT SUM((playerstats1.goals*5)+(playerstats1.assists*3)+(playerstats1.cleanSheets*3)+(playerstats1.played)+(playerstats1.sixtyMins)+(playerstats1.yCard * -1)+(playerstats1.rCard * -3)) 
FROM playerstats1 WHERE playerstats1.playerName = players.playerName)
UPDATE test_players SET price = 
case 
    when position = 'Goalkeeper' then ROUND(4 * 
        (case   
            when nation in ('Brazil','France','Belgium', 'Argentina','England','Spain','Netherlands', 'Portugal') then 1.4
            when nation in ('Denmark','Germany','Croatia','Mexico', 'Uruguay','Switzerland','United States','Senegal') then 1.3
            when nation in ('Wales','Iran','Serbia','Morocco', 'Japan','Poland','South Korea','Tunisia') then 1.2
            else 1.1
            end
        ),1)
    when position = 'Defender' then ROUND (4.5 * 
        (case   
            when nation in ('Brazil','France','Belgium', 'Argentina','England','Spain','Netherlands', 'Portugal') then 1.4
            when nation in ('Denmark','Germany','Croatia','Mexico', 'Uruguay','Switzerland','United States','Senegal') then 1.3
            when nation in ('Wales','Iran','Serbia','Morocco', 'Japan','Poland','South Korea','Tunisia') then 1.2
            else 1.1
            end
        ),1)
    when position = 'Midfielder' then ROUND(5 * 
        (case   
            when nation in ('Brazil','France','Belgium', 'Argentina','England','Spain','Netherlands', 'Portugal') then 1.4
            when nation in ('Denmark','Germany','Croatia','Mexico', 'Uruguay','Switzerland','United States','Senegal') then 1.3
            when nation in ('Wales','Iran','Serbia','Morocco', 'Japan','Poland','South Korea','Tunisia') then 1.2
            else 1.1
            end
        ),1)
    when position = 'Attacker' then ROUND(5.5* 
        (case   
            when nation in ('Brazil','France','Belgium', 'Argentina','England','Spain','Netherlands', 'Portugal') then 1.4
            when nation in ('Denmark','Germany','Croatia','Mexico', 'Uruguay','Switzerland','United States','Senegal') then 1.3
            when nation in ('Wales','Iran','Serbia','Morocco', 'Japan','Poland','South Korea','Tunisia') then 1.2
            else 1.1
            end
        ),1)
end
