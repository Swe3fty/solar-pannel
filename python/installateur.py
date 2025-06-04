import mysql.connector

#Connexion a la base de données
cnx = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='solar_pannel'
)
cursor = cnx.cursor()

#Ignore pour éviter d'avoir des doublons
sql_insert = """
INSERT IGNORE INTO installateur (nom_inst)
VALUES (%s)
"""

with open('datacsv.csv', 'r', encoding='latin-1') as fichier_source:
    for ligne in fichier_source:

        champs = ligne.strip().split(';')
        

        installateur = champs[11]
        

#Commande effectuer par le curseur
        cursor.execute(sql_insert, (installateur,))

cnx.commit()

cursor.close()
cnx.close()
