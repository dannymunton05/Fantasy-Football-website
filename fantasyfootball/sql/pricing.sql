UPDATE players SET price =
case
    when position = 'Goalkeeper' then ROUND(4 *
    (case
    when nation in ('Brazil', 'France', 'Belgium', 'Argentina', 'England', 'Spain', 'Netherlands', 'Portugal') then 1.4
    when nation in ('Denmark', 'Germany', 'Croatia', 'Mexico', 'Uruguay', 'Switzerland', 'United States', 'Senegal') then 1.3
    when nation in ('Wales', 'Iran', 'Serbia', 'Morocco', 'Japan', 'Poland', 'South Korea', 'Tunisia') then 1.2
    else 1.1
    end
    ),1)
    when position = 'Defender' then ROUND (4.5 *
    (case
    when nation in ('Brazil', 'France', 'Belgium', 'Argentina', 'England', 'Spain', 'Netherlands', 'Portugal') then 1.4
    when nation in ('Denmark', 'Germany', 'Croatia', 'Mexico', 'Uruguay', 'Switzerland', 'United States', 'Senegal') then 1.3
    when nation in ('Wales', 'Iran', 'Serbia', 'Morocco', 'Japan', 'Poland', 'South Korea', 'Tunisia') then 1.2
    else 1.1
    end
    ),1)
    when position = 'Midfielder' then ROUND(5 *
    (case
    when nation in ('Brazil', 'France', 'Belgium', 'Argentina', 'England', 'Spain', 'Netherlands', 'Portugal') then 1.4
    when nation in ('Denmark', 'Germany', 'Croatia', 'Mexico', 'Uruguay', 'Switzerland', 'United States', 'Senegal') then 1.3
    when nation in ('Wales', 'Iran', 'Serbia', 'Morocco', 'Japan', 'Poland', 'South Korea', 'Tunisia') then 1.2
    else 1.1
    end
    ),1)
    when position = 'Attacker' then ROUND(5.5*
    (case
    when nation in ('Brazil', 'France', 'Belgium', 'Argentina', 'England', 'Spain', 'Netherlands', 'Portugal') then 1.4
    when nation in ('Denmark', 'Germany', 'Croatia', 'Mexico', 'Uruguay', 'Switzerland', 'United States', 'Senegal') then 1.3
    when nation in ('Wales', 'Iran', 'Serbia', 'Morocco', 'Japan', 'Poland', 'South Korea', 'Tunisia') then 1.2
    else 1.1
    end

    ),1)
end