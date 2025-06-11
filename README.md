# Projet Panneaux Solaires

Ce projet est une application web dédiée à la gestion ou visualisation de données liées aux panneaux solaires.

## 👥 Auteurs
  - `Colin Rousseau
  - `Gaspard Vieujean

## Structure du projet
projet_panneaux_solaires/  
├── index.html # Page principale  
├── assets/ # Dossier des ressources statiques  
├── back/ # Contient toute la partie backend
    ├── /html # Fichier html du backend
├── csv/ # Fichier contenant les données au format csv  
├── css/ # Fichiers CSS  
├── js/ # Scripts JavaScript   
├── php/ # Scripts PHP  
├── sql/ # Scripts de base de données  
└── html/ # Pages HTML  


## Technologies utilisées

- Frontend:
  - HTML
  - CSS (Boostrap)
  - JavaScript (Ajax, REST, JSON)
- Backend:
  - PHP
  - Python
- Base de données:
  - SQL & MariaDB
- Serveur
  - Apache

## Installation

1. Cloner le dépôt :
   ```bash
   git clone [URL_DU_DEPOT]

2. Crée une BDD avec :
    ```
    CREATE DATABASE nom_bdd;
    ```

3. Exécuter le fichier solar_pannel.sql dedans :
    ```
    Faite un copier coller
    ```

4. Depuis le dossier csv ouvrir le fichier "Inserer dans la BDD.txt"
    ```
    Exécuter chaque commandes en choissisant bien le chemin
    ```

5. Crée votre user et administrer les droits avec : (adapter localhost ou l'ip de votre machine)
  ```
      CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
      GRANT ALL PRIVILEGES ON my_database.* TO 'username'@'localhost';
      FLUSH PRIVILEGES;
  ```
