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
        $cont = checkInput($_POST['content']);
        $top = checkInput($_POST['top']);
        echo deleteNote($top, $cont, $usrnm);
        break;

      case "save":
        $old = checkInput($_POST['oldText']);
        $new = checkInput($_POST['newText']);
        $x = checkInput($_POST['x']);
        $y = checkInput($_POST['y']);
        echo saveNote($old, $new, $x, $y, $usrnm);
        break;
    }
  }
?>
