<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: ../index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  include("noteContent.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "load":
        echo getNotes($usrnm);
        break;

      case "add":
        echo addNote($usrnm);
        break;

      case "delete":
        $x = checkInput($_POST['x']);
        $y = checkInput($_POST['y']);
        $cont = checkInput($_POST['cont']);
        echo deleteNote($x, $y, $cont, $usrnm);
        break;

      case "save":
        $i = checkInput($_POST['i']);
        $cont = checkInput($_POST['cont']);
        $x = checkInput($_POST['x']);
        $y = checkInput($_POST['y']);
        saveNote($cont, $x, $y, $i, $usrnm);
        break;
    }
  }
?>
