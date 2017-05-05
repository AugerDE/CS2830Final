<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: ../index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "load":
        echo "<iframe width='420' height='315' src='https://www.youtube.com/embed/A6XUVjK9W4o' frameborder='0' allowfullscreen></iframe>";
        break;
    }
  }
?>
