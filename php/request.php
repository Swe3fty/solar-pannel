<?php

  require_once('database.php');
  define('EVAL_DATETIME', '2025-05-06 10:00:00');

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

  if ($requestRessource == 'ex1' && $requestMethod == 'GET' && $id != NULL)
  {
    $data = dbGetName($db, intval($id));
    if ($data)
    {
      $origin = new DateTime(EVAL_DATETIME);
      $target = new DateTime('now');
      $interval = $target->diff($origin);
      $data = array($data['name'], strval($interval->h*60 + $interval->i).'.'.
        strval($interval->s));
    }
  }

  // Exercise 2.
  if ($requestRessource == 'ex2')
  {
    if ($requestMethod == 'GET' && $id != NULL && isset($_GET['step']))
    {
      if ($_GET['step'] == '1')
        $data = dbGetProcess($db, intval($id));
      if ($_GET['step'] == '2')
        $data = dbGetSate($db, intval($id));
    }
    if ($requestMethod == 'POST' && $id != NULL && isset($_POST['answer']))
      $data = dbSetAnswer($db, intval($id), $_POST['answer']);
  }

  // Exercise 3.
  if ($requestRessource == 'ex3')
  {
    if ($requestMethod == 'GET' && isset($_GET['value'])) 
        $data = strlen($_GET['value']); //renvoie la taille de la chaine

    if ($requestMethod == 'POST' && isset($_POST['value1']) && isset($_POST['value2']))
      $data = substr($_POST['value1'],$_POST['value2']);


      if ($requestMethod == 'DELETE' && isset($_GET['value1']) && isset($_GET['value2']) && isset($_GET['value3']))
      $data = str_replace($_GET['value1'],$_GET['value2'],$_GET['value3']);

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
