import mysql.connector
import csv
import unicodedata
import html

# Connexion à la base de données
cnx = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='solar_pannel'
)
cursor = cnx.cursor()


# Étape 1 : Créer le dictionnaire nom_commune → code_insee (clé nettoyée)
dico_insee = {}
with open('communescsv.csv', 'r', encoding='latin-1') as fichier_communes:
    reader = csv.reader(fichier_communes, delimiter=';')
    for champs in reader:
        if len(champs) >= 2:
            nom_commune = champs[1]
            code_insee = champs[0].strip()
            dico_insee[nom_commune] = code_insee

# Étape 2 : Requête SQL préparée
sql_insert = """
INSERT IGNORE INTO installation (
    nb_panneau, puissance_crete, surface, pente, production_pvgis,
    nb_onduleur, latitude, longitude, mois_inst, annee_inst, nom_inst, modele_ond, modele_panneau, code_insee
) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
"""

# Étape 3 : Lecture du fichier d'installation
with open('datacsv.csv', 'r', encoding='latin-1') as fichier_source:
    reader = csv.reader(fichier_source, delimiter=';')
    for index, champs in enumerate(reader, start=1):
        if len(champs) < 19:
            print(f"[Ligne {index}] Ignorée : champs insuffisants ({len(champs)} trouvés).")
            continue

        nom_commune = champs[17].strip()

        code_insee = dico_insee.get(nom_commune)
        if not code_insee:
            continue

        try:
            nb_panneau = int(champs[2])
            puissance_crete = int(champs[8])
            surface = int(champs[9])
            pente = int(champs[10])
            production_pvgis = int(champs[12])
            nb_onduleur = int(champs[5])
            latitude = float(champs[13])
            longitude = float(champs[14])
            mois_inst = int(champs[0])
            annee_inst = int(champs[1])
            nom_inst = champs[11]
            modele_panneau = champs[4]
            modele_ond = champs[6]

            cursor.execute(sql_insert, (
                nb_panneau, puissance_crete, surface, pente, production_pvgis,
                nb_onduleur, latitude, longitude, mois_inst, annee_inst, nom_inst, modele_ond, modele_panneau, code_insee
            ))
        except Exception as e:
            print(f"[Ligne {index}] Erreur lors de l'insertion SQL : {e}")

# Finalisation
cnx.commit()
cursor.close()
cnx.close()
