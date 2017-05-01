<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: ../index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  include("../functions.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "photos":
        echo displayPhotos();
        break;

      case "updatephoto":
        $src = checkInput($_POST['src']);
        $alt = checkInput($_POST['alt']);
        echo updatePhoto($src, $alt, $usrnm);
        break;

      case "userupdate":
        $new = checkInput($_POST['newUser']);
        echo updateUserName($new, $usrnm);
        $_SESSION['user'] = $new;
        break;

      case "emailupdate":
        $email = checkInput($_POST['newEmail']);
        echo updateUserEmail($email, $usrnm);
        break;

      case "passcheck":
        $pass = checkInput($_POST['pass']);
        $newPass = checkInput($_POST['newPass']);
        $stat = checkPassword($pass, $usrnm);
        if($stat != 1){
          echo $stat;
        }else{
          echo updatePassword($newPass, $usrnm);
        }
        break;
    }
  }
?>
