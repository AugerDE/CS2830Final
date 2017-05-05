<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: ../index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch($action){
      case "load":
        echo "<img src='https://img.youtube.com/vi/3t1PQJmM8P4/hqdefault.jpg' />
              <iframe width='420' height='315' src='https://www.youtube.com/embed/3t1PQJmM8P4' frameborder='0' allowfullscreen></iframe>";
        break;
    }
  }
?>
