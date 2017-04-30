<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  include("functions.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    $_SESSION['tab'] = $action;
    switch($action){
      case "home":
        echo getHomeDash();
        break;
      case "notes":
        break;
      case "tasks":
        echo getTasks($usrnm);
        break;
      case "update":
        $name = checkInput($_POST['name']);
        $tasks = getTasks($usrnm);
        $task = editTask($name, $usrnm);
        echo $tasks.$task;
      case "video":
        break;
      default:
    }
  }

?>
