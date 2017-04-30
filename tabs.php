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
      case "edit":
        $task = (isset($_SESSION['task']) ? $_SESSION['task'])
        $tasks = getTasks($usrnm);
      case "video":
        break;
      default:
    }
  }

?>
