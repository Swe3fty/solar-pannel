<?php
  require_once('database.php');
  // Database connexion.
  $db = dbConnect();
  if (!$db)
  {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
  }

  // Check the request.
  $requestMethod = $_SERVER['REQUEST_METHOD'];
  $request = substr($_SERVER['PATH_INFO'], 1);
  $request = explode('/', $request);
  $requestRessource = array_shift($request);

  // Check id.
  $data = false;
  $id = array_shift($request);
  if ($id == '')
    $id = NULL;


  
  if ($requestRessource == 'installationsMap')
  {
    if ($requestMethod == 'GET' && isset($_GET['annee-installation']) && isset($_GET['departementSelect'])) 
        $data = dbRequestCoordonnees($db, $_GET['annee-installation'] , $_GET['departementSelect']);

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
