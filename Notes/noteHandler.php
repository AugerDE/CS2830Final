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
        $id = $_POST['id'];
        $cont = $_POST['cont'];
        echo addNote($id, $cont, $usrnm);
        break;

      case "delete":
        $id = checkInput($_POST['id']);
        echo deleteNote($id, $usrnm);
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
