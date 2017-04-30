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
    switch($action){
      case "home":
        echo getHomeDash();
        break;
      case "notes":
        break;
      case "tasks":
        $_SESSION['tab'] = "tasks";
        echo getTasks($usrnm);
        break;
      case "video":
        break;
      default:
    }
  }

?>
