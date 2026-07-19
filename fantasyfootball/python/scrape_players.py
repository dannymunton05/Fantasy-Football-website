import requests
from bs4 import BeautifulSoup
import mysql.connector
cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='fantasyfootball',)
cursor = cnx.cursor()
url = "https://fbref.com/play-index/share.fcgi?id=qThlH&output=iframe"
response = requests.get(url)
soup =  BeautifulSoup(response.content,'html.parser')
tables = soup.find_all("table")
table = soup.find('table')
rows = table.find_all('tr')
def getPlayerName(i):
  nameArray = []
  for row in rows:
        cols = row.find_all('td')
        if cols:
            playerName = cols[0].text
            nameArray.append(playerName)     
  return nameArray[i]
def getPlayerPosition(i):
    positionArray = []  
    for row in rows:
        cols = row.find_all('td')
        if cols:
            position = cols[1].text
            position1 = position[:2]
            if position1 == "GK":
                position2 = "Goalkeeper"
            elif position1 == "DF":
                position2 = "Defender"
            elif position1 == "MF":
                position2 = "Midfielder"
            elif position1 == "FW":
                position2 = "Attacker"
            positionArray.append(position2) 
    return positionArray[i] 
def getPlayerNation(i):
    nationArray = []
    for row in rows:
        cols = row.find_all('td')
        if cols:
            nation = cols[2].text
            nation1 = nation[3:]
            nationArray.append(nation1)     
    return nationArray[i]
insertValues = ""
for x in range(680):
    insertValues += "(\"" + getPlayerName(x) + "\", \"" + getPlayerPosition(x)+ "\", \"" + getPlayerNation(x) + "\")" + ","


insertValues = insertValues[:-1]
sql = "insert into test_players (playerName, position, nation) VALUES " + insertValues
cursor.execute(sql)
cnx.commit()
cursor.close()
cnx.close()
