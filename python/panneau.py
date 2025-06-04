import mysql.connector

#Connexion a la base de données
cnx = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='solar_pannel'
)
#Création d'un objet curseur qui permet d'effectuer des requête sql
cursor = cnx.cursor()

#Ignore pour éviter d'avoir des doublons
sql_insert = """
INSERT IGNORE INTO panneau (modele_panneau, marque_panneau)
VALUES (%s, %s)
"""

with open('datacsv.csv', 'r', encoding='latin-1') as fichier_source:
    for ligne in fichier_source:

        champs = ligne.strip().split(';')
        

        modele_panneau = champs[4]
        marque_panneau = champs[3]

#Commande effectuer par le curseur
        cursor.execute(sql_insert, (modele_panneau, marque_panneau))


cnx.commit()
cursor.close()
cnx.close()
