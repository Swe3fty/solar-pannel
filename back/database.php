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
  // Récupère toutes les photos (miniatures)
  function dbRequestPhotos($db) {
    try {
      $request = 'SELECT id, small FROM photos';
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
  // Récupère une photo spécifique
  function dbRequestPhoto($db, $id) {
    try {
      $request = 'SELECT id, title, large FROM photos WHERE id=:id';
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }



  //----------------------------------------------------------------------------
  // Récupère les coordonnées de toute les installations
  function dbRequestCoordonnees($db) {
    try {
      $request = 'SELECT  id, latitude, longitude FROM installation';
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
  function dbAddInstallation($db, $nb_panneau, $puissance_crete, $surface, $pente, $production_pvgis, $nb_onduleur, $latitude, $longitude, $mois_inst, $annee_inst, $nom_inst, $modele_ond, $modele_panneau, $code_insee) {
    try {
        $request = 'INSERT INTO installation (nb_panneau, puissance_crete, surface, pente, production_pvgis, nb_onduleur, latitude, longitude, mois_inst, annee_inst, nom_inst,modele_ond, modele_panneau, code_insee) 
                    VALUES (:nb_panneau, :photoId, :userLogin)';
        $statement = $db->prepare($request);
        $statement->bindParam(':nb_panneau', $nb_panneau, PDO::PARAM_INT);
        $statement->bindParam(':nb_onduleur', $nb_onduleur, PDO::PARAM_INT);
        $statement->bindParam(':puissance_crete', $puissance_crete, PDO::PARAM_INT);
        $statement->bindParam(':surface', $surface, PDO::PARAM_INT);
        $statement->bindParam(':pente', $pente, PDO::PARAM_INT);
        $statement->bindParam(':latitude', $latitude, PDO::PARAM_FLOAT);
        $statement->bindParam(':longitude', $longitude, PDO::PARAM_FLOAT);
        $statement->bindParam(':production_pvgis', $production_pvgis, PDO::PARAM_INT);
        $statement->bindParam(':mois_inst', $mois_inst, PDO::PARAM_INT);
        $statement->bindParam(':annee_inst', $annee_inst, PDO::PARAM_INT);
        $statement->bindParam(':nom_inst', $nom_inst, PDO::PARAM_STR, 64);
        $statement->bindParam(':modele_ond', $modele_ond, PDO::PARAM_STR, 64);
        $statement->bindParam(':modele_panneau', $modele_panneau, PDO::PARAM_STR, 64);
        $statement->bindParam(':code_insee', $code_insee, PDO::PARAM_INT);

        $statement->execute();
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  //----------------------------------------------------------------------------
  // Modifie un commentaire A FAIRE APRES
  function dbModifyInstallation($db, $nb_panneau, $puissance_crete, $surface, $pente, $production_pvgis, $nb_onduleur, $latitude, $longitude, $mois_inst, $annee_inst, $nom_inst, $modele_ond, $modele_panneau, $code_insee) {
    try {
      $request = 'UPDATE comments SET comment=:comment 
                 WHERE id=:id AND userLogin=:userLogin';
      $statement = $db->prepare($request);
      $statement->bindParam(':nb_panneau', $nb_panneau, PDO::PARAM_INT);
        $statement->bindParam(':nb_onduleur', $nb_onduleur, PDO::PARAM_INT);
        $statement->bindParam(':puissance_crete', $puissance_crete, PDO::PARAM_INT);
        $statement->bindParam(':surface', $surface, PDO::PARAM_INT);
        $statement->bindParam(':pente', $pente, PDO::PARAM_INT);
        $statement->bindParam(':latitude', $latitude, PDO::PARAM_FLOAT);
        $statement->bindParam(':longitude', $longitude, PDO::PARAM_FLOAT);
        $statement->bindParam(':production_pvgis', $production_pvgis, PDO::PARAM_INT);
        $statement->bindParam(':mois_inst', $mois_inst, PDO::PARAM_INT);
        $statement->bindParam(':annee_inst', $annee_inst, PDO::PARAM_INT);
        $statement->bindParam(':nom_inst', $nom_inst, PDO::PARAM_STR, 64);
        $statement->bindParam(':modele_ond', $modele_ond, PDO::PARAM_STR, 64);
        $statement->bindParam(':modele_panneau', $modele_panneau, PDO::PARAM_STR, 64);
        $statement->bindParam(':code_insee', $code_insee, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //----------------------------------------------------------------------------

?>