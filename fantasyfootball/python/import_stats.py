import mysql.connector
import xlrd
cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='fantasyfootball',)
cursor = cnx.cursor()
location = (r"C:\Users\danny\OneDrive\Desktop\ENG_USA.xlsx")
spreadsheet = xlrd.open_workbook(location)
sheet = spreadsheet.sheet_by_index(0)
sheet.cell_value(0,0)
stats = [] 
for x in range (1,35):
    stats.append(sheet.row_values(x))
insertValues = (str(stats)[1:][:-1])
insertValues = insertValues.replace("[","(")
insertValues = insertValues.replace("]",")")
sql = "insert into tempstats1 values " + insertValues
cursor.execute(sql)
cnx.commit()
cursor.close()
cnx.close()
