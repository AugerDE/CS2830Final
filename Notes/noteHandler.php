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
        $cont = $_POST['cont'];
        $html = explode(',', $cont);
        $left = $_POST['x'];
        $x = explode(',', $left);
        $top = $_POST['y'];
        $y = explode(',', $top);
        $stat = clearNotes($usrnm);
        if($stat == 1){
          $len = count($x);
          for($i = 0; $i < $len; $i++){
            saveTask($cont[$i], $x[$i], $y[$i], $usrnm);
          }
        }else{
          echo $stat;
        }
        break;
    }
  }
?>
