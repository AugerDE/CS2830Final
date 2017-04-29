<?php
  include("functions.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    $usrnm = checkInput($_POST['usrnm']);
    switch($action){
      case "notes":
        echo getTasks($usrnm);
        break;
      case "tasks":
        break;
      case "video":
        break;
      default:
    }
  }
?>
