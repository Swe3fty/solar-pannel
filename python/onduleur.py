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
INSERT IGNORE INTO onduleur (modele_ond, marque_ond)
VALUES (%s, %s)
"""

with open('datacsv.csv', 'r', encoding='latin-1') as fichier_source:
    for ligne in fichier_source:

        champs = ligne.strip().split(';')
        

        modele_ond = champs[7]
        marque_ond = champs[6]

#Commande effectuer par le curseur
        cursor.execute(sql_insert, (modele_ond, marque_ond))

cnx.commit()

cursor.close()
cnx.close()
