<?php
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
        $usrnm = checkInput($_POST['usrnm']);
        echo getTasks($usrnm);
        break;
      case "video":
        break;
      default:
    }
  }

?>
