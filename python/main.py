import pandas as pd
from sqlalchemy import create_engine

# Configuration de la connexion MySQL
db_config = {
    'user': 'votre_utilisateur',
    'password': 'votre_mot_de_passe',
    'host': 'localhost',
    'database': 'projet_panneau_solaire'
}

# Création de la connexion
engine = create_engine(f"mysql+mysqlconnector://{db_config['user']}:{db_config['password']}@{db_config['host']}/{db_config['database']}")

# Chargement du fichier CSV
csv_file = 'votre_fichier.csv'
data = pd.read_csv(csv_file)

# 1. Préparation des données pour la table 'date'
date_data = data[['mois_installation', 'annee_installation']].drop_duplicates()

# 2. Préparation des données pour la table 'installation'
installation_cols = [
    'nb_panneau', 'marque_panneau', 'modele_panneau', 'puissance_crete',
    'surface', 'pente', 'production_pvgis', 'nb_onduleur', 'marque_onduleur',
    'modele_onduleur', 'installateur', 'mois_installation', 'annee_installation'
]
installation_data = data[installation_cols]

# 3. Préparation des données pour la table 'lieu'
lieu_cols = [
    'longitude', 'latitude', 'code_region', 'nom_region', 'code_postal',
    'code_departement', 'nom_departement', 'code_insee', 'nom_ville',
    'population', 'id_installation'  # Note: id_installation sera ajouté après
]
lieu_data = data[lieu_cols[:-1]]  # On prend toutes les colonnes sauf id_installation

try:
    # 1. Insertion dans 'date' (doit être fait en premier)
    date_data.to_sql('date', con=engine, if_exists='append', index=False)
    
    # 2. Insertion dans 'installation' (avec l'ID auto-incrémenté)
    installation_data.to_sql('installation', con=engine, if_exists='append', index=False)
    
    # 3. Maintenant on peut récupérer les IDs pour la table 'lieu'
    # On lit les installations qu'on vient d'insérer pour avoir leurs IDs
    query = "SELECT id_installation, mois_installation, annee_installation FROM installation"
    installations = pd.read_sql(query, engine)
    
    # On fusionne avec les données originales pour avoir les IDs correspondants
    lieu_data = pd.merge(data, installations, 
                        on=['mois_installation', 'annee_installation'])
    lieu_data = lieu_data[lieu_cols]  # On garde seulement les colonnes nécessaires
    
    # Insertion dans 'lieu'
    lieu_data.to_sql('lieu', con=engine, if_exists='append', index=False)
    
    print("Importation terminée avec succès!")
    
except Exception as e:
    print(f"Erreur lors de l'importation: {e}")
finally:
    engine.dispose()