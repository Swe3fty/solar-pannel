<?php
  require_once('constantes.php');

  //----------------------------------------------------------------------------
  // Connexion à la base de données
  function dbConnect() {
    try {
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8;port='.DB_PORT, 
                   DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    } catch (PDOException $exception) {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

  //----------------------------------------------------------------------------
  // Récupère les coordonnées de toute les installations
  function dbRequestCoordonnees($db) {
    try {
      $request = 'SELECT  id_installation, latitude, longitude, puissance_crete, departement.nom_dep, departement.nom_reg, annee_inst FROM installation JOIN ville ON installation.code_insee = ville.code_insee JOIN departement ON ville.nom_dep = departement.nom_dep';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }
  //----------------------------------------------------------------------------
  // Récupère une installation en fonction de l'id
  function dbRequestInstallationId($db,$id){
      try {
      $request = 'SELECT 
                  i.*,
                  o.marque_ond,
                  p.marque_panneau,
                  v.nom_ville
                  FROM installation i
                  JOIN onduleur o ON i.modele_ond = o.modele_ond
                  JOIN panneau p ON i.modele_panneau = p.modele_panneau
                  JOIN ville v ON i.code_insee = v.code_insee
                  WHERE i.id_installation = :id_installation;
      ';
      $statement = $db->prepare($request);
      $statement->bindParam(':id_installation', $id, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }
  
  //----------------------------------------------------------------------------
  // Récupère les statistiques de la première page
  function dbRequest100Installations($db) {
    try {
      $request = 'SELECT 
                      i.id_installation,
                      i.nb_panneau,
                      i.puissance_crete,
                      i.surface,
                      i.pente,
                      i.production_pvgis,
                      i.nb_onduleur,
                      i.latitude,
                      i.longitude,
                      i.mois_inst,
                      i.annee_inst,
                      ins.nom_inst,
                      o.marque_ond,
                      o.modele_ond,
                      p.marque_panneau,
                      p.modele_panneau,
                      v.nom_ville,
                      v.code_insee
                    FROM installation i
                    JOIN installateur ins ON i.nom_inst = ins.nom_inst
                    JOIN onduleur o ON i.modele_ond = o.modele_ond
                    JOIN panneau p ON i.modele_panneau = p.modele_panneau
                    JOIN ville v ON i.code_insee = v.code_insee
                    ORDER BY i.id_installation ASC
                    LIMIT 100;
      ';
      $statement = $db->prepare($request);   
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }



  //----------------------------------------------------------------------------
  // Récupère les statistiques de la première page
  function dbRequestStats($db) {
    try {
      $request = 'SELECT
                  COUNT(DISTINCT installation.id_installation) AS nb_installations,
                  COUNT(DISTINCT installateur.nom_inst) AS nb_installateurs,
                  COUNT(DISTINCT panneau.marque_panneau) AS nb_marques_panneaux,
                  COUNT(DISTINCT onduleur.modele_ond) AS nb_marques_onduleurs
                  FROM installation
                  JOIN installateur ON installation.nom_inst = installateur.nom_inst
                  JOIN panneau ON installation.modele_panneau = panneau.modele_panneau
                  JOIN onduleur ON installation.modele_ond = onduleur.modele_ond;
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  //----------------------------------------------------------------------------
  // Récupère les installations par années
  function dbRequestInstallationsYear($db) {
    try {
      $request = 'SELECT annee_inst AS annee, COUNT(*) AS total
        FROM installation
        GROUP BY annee
        ORDER BY annee ASC;';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  //----------------------------------------------------------------------------
  // Récupère les installations par années
  function dbRequestInstallationsRegion($db) {
    try {
      $request = 'SELECT
                  region.nom_reg,
                  COUNT(DISTINCT installation.id_installation) AS nb_installations
                  FROM installation
                  JOIN ville ON installation.code_insee = ville.code_insee
                  JOIN departement ON ville.nom_dep = departement.nom_dep
                  JOIN region ON departement.nom_reg = region.nom_reg
                  GROUP BY region.nom_reg
                  ORDER BY nb_installations DESC;
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }


  //----------------------------------------------------------------------------
  // Récupère les installations par années et par régions
  function dbRequestInstallationsRegionAndYear($db) {
    try {
      $request = 'SELECT
                  installation.annee_inst,
                  region.nom_reg,
                  COUNT(DISTINCT installation.id_installation) AS nb_installations
                  FROM installation
                  JOIN ville ON installation.code_insee = ville.code_insee
                  JOIN departement ON ville.nom_dep = departement.nom_dep
                  JOIN region ON departement.nom_reg = region.nom_reg
                  GROUP BY installation.annee_inst, region.nom_reg
                  ORDER BY installation.annee_inst, region.nom_reg;
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  // //----------------------------------------------------------------------------
  // // Récupère 20 marques d'onduleurs les plus présents
  function dbRequestSelectOnduleurs($db) {
    try {
      $request = 'SELECT o.marque_ond, COUNT(*) AS nb_installations
                  FROM installation i
                  JOIN onduleur o ON i.modele_ond = o.modele_ond
                  GROUP BY o.marque_ond
                  ORDER BY nb_installations DESC
                  LIMIT 20;
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  // //----------------------------------------------------------------------------
  // // Récupère 20 marques de panneaux les plus utilisés
  function dbRequestSelectPanneaux($db) {
    try {
      $request = 'SELECT p.marque_panneau, COUNT(*) AS nb_installations
                  FROM installation i
                  JOIN panneau p ON i.modele_panneau = p.modele_panneau
                  GROUP BY p.marque_panneau
                  ORDER BY nb_installations DESC
                  LIMIT 20;
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  //----------------------------------------------------------------------------
  // Récupère 20 départements aléatoires
  function dbRequestRandomDepartements($db) {
    try {
      $request = 'SELECT DISTINCT d.nom_dep
                  FROM departement d
                  JOIN ville v ON d.nom_dep = v.nom_dep
                  JOIN installation i ON i.code_insee = v.code_insee
                  ORDER BY RAND()
                  LIMIT 20;
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  // //----------------------------------------------------------------------------
  // // Récupère les informations pour les afficher dans research.html
  function dbRequestInstallationsByFilters($db, $marqueOnd, $marquePanneau, $nomDep) {
    try {
      $request = '
        SELECT 
          i.id_installation,
          i.mois_inst,
          i.annee_inst,
          i.nb_panneau,
          i.surface,
          i.puissance_crete,
          i.latitude,
          i.longitude
        FROM installation i
        JOIN onduleur o ON i.modele_ond = o.modele_ond
        JOIN panneau p ON i.modele_panneau = p.modele_panneau
        JOIN ville v ON i.code_insee = v.code_insee
        JOIN departement d ON v.nom_dep = d.nom_dep
        WHERE o.marque_ond = :marqueOnd
          AND p.marque_panneau = :marquePanneau
          AND d.nom_dep = :nomDep
      ';

      $statement = $db->prepare($request);
      $statement->bindParam(':marqueOnd', $marqueOnd, PDO::PARAM_STR);
      $statement->bindParam(':marquePanneau', $marquePanneau, PDO::PARAM_STR);
      $statement->bindParam(':nomDep', $nomDep, PDO::PARAM_STR);

      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $exception) {
      error_log('Request error: ' . $exception->getMessage());
      return false;
    }

    return $result;
  }

  //----------------------------------------------------------------------------
  // Récupère 40 modèles de panneaux aléatoires
  function dbRequestRandomPannels($db) {
    try {
      $request = 'SELECT modele_panneau
                  FROM panneau
                  ORDER BY RAND()  
                  LIMIT 40; 
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  //----------------------------------------------------------------------------
  // Récupère 40 modèles d'onduleurs aléatoires
  function dbRequestRandomOnduleurs($db) {
    try {
      $request = 'SELECT modele_ond
                  FROM onduleur
                  ORDER BY RAND()  
                  LIMIT 40; 
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  
  //----------------------------------------------------------------------------
  // Récupère 40 installateurs aléatoires
  function dbRequestRandomInstallateurs($db) {
    try {
      $request = 'SELECT nom_inst
                  FROM installateur
                  ORDER BY RAND()  
                  LIMIT 40; 
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  //----------------------------------------------------------------------------
  // Récupère 40 code insee aléatoires
  function dbRequestRandomCodeInsee($db) {
    try {
      $request = 'SELECT code_insee
                  FROM ville
                  ORDER BY RAND()  
                  LIMIT 40; 
      ';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
   
  }

  //----------------------------------------------------------------------------
  // Ajoute une installation
  function dbAddInstallation($db,$data) {
    
    try {
        $request = 'INSERT INTO installation (
                      nb_panneau,
                      puissance_crete,
                      surface,
                      pente,
                      production_pvgis,
                      nb_onduleur,
                      latitude,
                      longitude,
                      mois_inst,
                      annee_inst,
                      nom_inst,
                      modele_ond,
                      modele_panneau,
                      code_insee
                  ) VALUES (
                      :nb_panneau,
                      :puissance_crete,
                      :surface,
                      :pente,
                      :production_pvgis,
                      :nb_onduleur,
                      :latitude,
                      :longitude,
                      :mois_inst,
                      :annee_inst,
                      :nom_inst,
                      :modele_ond,
                      :modele_panneau,
                      :code_insee
                  );
                      ';
        
        $statement = $db->prepare($request);
        
      $statement = $db->prepare($request);

      $statement->bindParam(':nb_panneau', $data['nb_panneau'], PDO::PARAM_INT);
      $statement->bindParam(':puissance_crete', $data['puissance_crete'], PDO::PARAM_INT);
      $statement->bindParam(':surface', $data['surface'], PDO::PARAM_INT);
      $statement->bindParam(':pente', $data['pente'], PDO::PARAM_INT);
      $statement->bindParam(':production_pvgis', $data['production_pvgis'], PDO::PARAM_INT);
      $statement->bindParam(':nb_onduleur', $data['nb_onduleur'], PDO::PARAM_INT);
      $statement->bindParam(':latitude', $data['latitude'], PDO::PARAM_STR);
      $statement->bindParam(':longitude', $data['longitude'], PDO::PARAM_STR);
      $statement->bindParam(':mois_inst', $data['mois_inst'], PDO::PARAM_INT);
      $statement->bindParam(':annee_inst', $data['annee_inst'], PDO::PARAM_INT);
      $statement->bindParam(':nom_inst', $data['nom_inst'], PDO::PARAM_STR);
      $statement->bindParam(':modele_ond', $data['modele_ond'], PDO::PARAM_STR);
      $statement->bindParam(':modele_panneau', $data['modele_panneau'], PDO::PARAM_STR);
      $statement->bindParam(':code_insee', $data['code_insee'], PDO::PARAM_INT);

      $statement->execute();

    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  //----------------------------------------------------------------------------
  // Modifie une installation
  function dbModifyInstallation($db,$data) {
    
    try {
        $request = 'UPDATE installation SET 
                    nb_panneau = :nb_panneau,
                    puissance_crete = :puissance_crete,
                    surface = :surface,
                    pente = :pente,
                    production_pvgis = :production_pvgis,
                    nb_onduleur = :nb_onduleur,
                    latitude = :latitude,
                    longitude = :longitude,
                    mois_inst = :mois_inst,
                    annee_inst = :annee_inst,
                    nom_inst = :nom_inst,
                    modele_ond = :modele_ond,
                    modele_panneau = :modele_panneau,
                    code_insee = :code_insee
                    WHERE id_installation = :id_installation;
        ';
        
      $statement = $db->prepare($request);
        
      $statement = $db->prepare($request);

      $statement->bindParam(':nb_panneau', $data['nb_panneau'], PDO::PARAM_INT);
      $statement->bindParam(':puissance_crete', $data['puissance_crete'], PDO::PARAM_INT);
      $statement->bindParam(':surface', $data['surface'], PDO::PARAM_INT);
      $statement->bindParam(':pente', $data['pente'], PDO::PARAM_INT);
      $statement->bindParam(':production_pvgis', $data['production_pvgis'], PDO::PARAM_INT);
      $statement->bindParam(':nb_onduleur', $data['nb_onduleur'], PDO::PARAM_INT);
      $statement->bindParam(':latitude', $data['latitude'], PDO::PARAM_STR);
      $statement->bindParam(':longitude', $data['longitude'], PDO::PARAM_STR);
      $statement->bindParam(':mois_inst', $data['mois_inst'], PDO::PARAM_INT);
      $statement->bindParam(':annee_inst', $data['annee_inst'], PDO::PARAM_INT);
      $statement->bindParam(':nom_inst', $data['nom_inst'], PDO::PARAM_STR);
      $statement->bindParam(':modele_ond', $data['modele_ond'], PDO::PARAM_STR);
      $statement->bindParam(':modele_panneau', $data['modele_panneau'], PDO::PARAM_STR);
      $statement->bindParam(':code_insee', $data['code_insee'], PDO::PARAM_INT);
      $statement->bindParam(':id_installation', $data['id_installation'], PDO::PARAM_INT);

      $statement->execute();

    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

