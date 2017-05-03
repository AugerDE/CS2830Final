<?php
  session_start();
  ob_start();

  include("indexContent.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "content":
        echo getContent();
        break;

      case "login":
        $usrnm = checkInput($_POST['usrnm']);
        $psswd = checkInput($_POST['psswd']);
        $status = login($usrnm, $psswd);
        if($status == 1){
          $_SESSION['user'] = $usrnm;
          $_SESSION['status'] = "active";
          echo $status;
        }else{
          echo $status;
        }
        break;

      case "register":
        $email = checkInput($_POST['email']);
        $usrnm = checkInput($_POST['usrnm']);
        $psswd = checkInput($_POST['psswd']);
        $pconf = checkInput($_POST['pconf']);
        $status = register($email, $usrnm, $psswd, $pconf);
        if($status == 1){
          $_SESSION['user'] = $usrnm;
          $_SESSION['status'] = "active";
          echo $status;
        }else{
          echo $status;
        }
        break;
    }
  }
?>
