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

  if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch($action){
      case "load":
        echo getNotes($usrnm);
        break;

      case "add":
        echo addNote($usrnm);
        break;

      case "delete":
        $id = checkInput($_GET['id']);
        echo deleteNote($id, $usrnm);
        break;

      case "save":
        $old = checkInput($_GET['oldText']);
        $new = checkInput($_GET['newText']);
        $x = checkInput($_GET['x']);
        $y = checkInput($_GET['y']);
        echo saveNote($old, $new, $x, $y, $usrnm);
        break;
    }
  }
?>
