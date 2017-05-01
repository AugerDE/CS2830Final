<?php
  session_start();
  ob_start();

  include("functions.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "login":
        $usrnm = checkInput($_POST['usrnm']);
        $psswd = checkInput($_POST['psswd']);
        break;
    }
  }
?>
