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
INSERT IGNORE INTO departement (nom_dep, nom_reg)
VALUES (%s, %s)
"""

with open('communescsv.csv', 'r', encoding='latin-1') as fichier_source:
    for ligne in fichier_source:

        champs = ligne.strip().split(';')
        
        nom_reg = champs[3]
        nom_dep = champs[5]

#Commande effectuer par le curseur
        cursor.execute(sql_insert, (nom_dep,nom_reg))


cnx.commit()
cursor.close()
cnx.close()
