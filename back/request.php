<?php
  require_once('database.php');

  // Database connexion.
  $db = dbConnect();
  if (!$db) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
  }

  // Check the request.
  $requestMethod = $_SERVER['REQUEST_METHOD'];
  $request = substr($_SERVER['PATH_INFO'], 1);
  $request = explode('/', $request);
  $requestRessource = array_shift($request);

  // Set data at false
  $data = false;


  /*================Method Get=============*/
  if($requestMethod == 'GET'){
    if ($requestRessource == 'stats'){
      $data = dbRequestStats($db);
    }
    if ($requestRessource == 'installationYearChart'){
      $data = dbRequestInstallationsYear($db);
    }
    if ($requestRessource == 'installationRegionChart'){
      $data = dbRequestInstallationsRegion($db);
    }
    if ($requestRessource == 'installationRegionYear'){
      $data = dbRequestInstallationsRegionAndYear($db);
    }
    if ($requestRessource == 'onduleurs-select'){
      $data = dbRequestSelectOnduleurs($db);
    }
    if ($requestRessource == 'panneaux-select'){
      $data = dbRequestSelectPanneaux($db);
    }
    if ($requestRessource == 'departements-select'){
      $data = dbRequestRandomDepartements($db);
    }
    if($requestRessource == 'results-select' && !empty($_GET['marque_ond']) && !empty($_GET['marque_panneau']) && !empty($_GET['departement'])){
      $data = dbRequestInstallationsByFilters($db,$_GET['marque_ond'],$_GET['marque_panneau'],$_GET['departement']);
    }
    if($requestRessource == 'all-details' && !empty($_GET['id'])){
      $data = dbRequestInstallationId($db,intval($_GET['id']));
    }
    if($requestRessource == 'installations-vis'){
      $data = dbRequest100Installations($db);
    }
    if($requestRessource == 'random-pannel'){
      $data = dbRequestRandomPannels($db);
    }
     if($requestRessource == 'random-onduleur'){
      $data = dbRequestRandomOnduleurs($db);
    }
    if($requestRessource == 'random-installateur'){
      $data = dbRequestRandomInstallateurs($db);
    }
    if($requestRessource == 'random-code-insee'){
      $data = dbRequestRandomCodeInsee($db);
    }
    if ($requestRessource == 'installationsMap')
    {
      if ($requestMethod == 'GET') 
          $data = dbRequestCoordonnees($db);
    }
  }

  /*==============Method Post=============*/
  if($requestMethod == 'POST'){
    if($requestRessource == 'add-installation'){
       $data = [
        'nb_panneau'       => isset($_POST['nb_panneau']) ? (int)$_POST['nb_panneau'] : null,
        'puissance_crete'  => isset($_POST['p_crete']) ? (int)$_POST['p_crete'] : null,
        'surface'          => isset($_POST['surface']) ? (int)$_POST['surface'] : null,
        'pente'            => isset($_POST['pente']) ? (int)$_POST['pente'] : null,
        'production_pvgis' => isset($_POST['pvgis']) ? (int)$_POST['pvgis'] : null,
        'nb_onduleur'      => isset($_POST['nb_onduleur']) ? (int)$_POST['nb_onduleur'] : null,
        'latitude'         => isset($_POST['latitude']) ? floatval($_POST['latitude']) : null,
        'longitude'        => isset($_POST['longitude']) ? floatval($_POST['longitude']) : null,
        'mois_inst'        => isset($_POST['mois_installation']) ? (int)$_POST['mois_installation'] : null,
        'annee_inst'       => isset($_POST['annee_installation']) ? (int)$_POST['annee_installation'] : null,
        'nom_inst'         => isset($_POST['installateur']) ? $_POST['installateur'] : null,
        'modele_ond'       => isset($_POST['modele_onduleur']) ? $_POST['modele_onduleur'] : null,
        'modele_panneau'   => isset($_POST['modele_panneau']) ? $_POST['modele_panneau'] : null,
        'code_insee'       => isset($_POST['code_insee']) ? (int)$_POST['code_insee'] : null,
      ];
      $success = dbAddInstallation($db, $data);

      if (!$success) {
          http_response_code(500);
          echo json_encode(['message' => 'Erreur lors de l\'ajout']);
          exit;
      }
    }
  }
  
  /*==============Method Put==========*/
  if($requestMethod == 'PUT'){
      parse_str(file_get_contents('php://input'), $_PUT);
      if($requestRessource == 'modify-installation'){
          $datas = [
            'id_installation'  => isset($_PUT['id_installation']) ? (int)$_PUT['id_installation'] :null,
            'nb_panneau'       => isset($_PUT['nb_panneau']) ? (int)$_PUT['nb_panneau'] : null,
            'puissance_crete'  => isset($_PUT['puissance_crete']) ? (int)$_PUT['puissance_crete'] : null,
            'surface'          => isset($_PUT['surface']) ? (int)$_PUT['surface'] : null,
            'pente'            => isset($_PUT['pente']) ? (int)$_PUT['pente'] : null,
            'production_pvgis' => isset($_PUT['production_pvgis']) ? (int)$_PUT['production_pvgis'] : null,
            'nb_onduleur'      => isset($_PUT['nb_onduleur']) ? (int)$_PUT['nb_onduleur'] : null,
            'latitude'         => isset($_PUT['latitude']) ? floatval($_PUT['latitude']) : null,
            'longitude'        => isset($_PUT['longitude']) ? floatval($_PUT['longitude']) : null,
            'mois_inst'        => isset($_PUT['mois_inst']) ? (int)$_PUT['mois_inst'] : null,
            'annee_inst'       => isset($_PUT['annee_inst']) ? (int)$_PUT['annee_inst'] : null,
            'nom_inst'         => isset($_PUT['nom_inst']) ? $_PUT['nom_inst'] : null,
            'modele_ond'       => isset($_PUT['modele_ond']) ? $_PUT['modele_ond'] : null,
            'modele_panneau'   => isset($_PUT['modele_panneau']) ? $_PUT['modele_panneau'] : null,
            'code_insee'       => isset($_PUT['code_insee']) ? (int)$_PUT['code_insee'] : null,
          ];
          $data = dbModifyInstallation($db,$datas);
      }
  }



  // Send data to the client.
  if ($data)
  {

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');

    if ($requestMethod == 'POST')
      header('HTTP/1.1 201 Created');
    else
      header('HTTP/1.1 200 OK');
      echo json_encode($data);
    exit;
  } 
  
  // Bad request case.
  header('HTTP/1.1 400 Bad Request');
?>
