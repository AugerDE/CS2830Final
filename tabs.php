<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  include("functions.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    $_SESSION['tab'] = $action;
    switch($action){
      case "home":
        echo getHomeDash();
        break;

      case "notes":
        break;

      case "tasks":
        echo getTasks($usrnm);
        break;

      case "edit":
        $name = checkInput($_POST['name']);
        $tasks = getTasks($usrnm);
        $task = editTask($name, $usrnm);
        echo $tasks.$task;
        break;

      case "update":
        $task = checkInput($_POST['task']);
        $name = checkInput($_POST['name']);
        $desc = checkInput($_POST['desc']);
        $date = checkInput($_POST['date']);
        $time = checkInput($_POST['time']);
        $stat = checkInput($_POST['stat']);
        updateTask($task, $name, $desc, $date, $time, $stat, $usrnm);
        echo getTasks($usrnm);
        break;

      case "delete":
        $name = checkInput($_POST['name']);
        $tasks = getTasks($usrnm);
        $task = taskToDelete($name, $usrnm);
        $confirm = updateConfirm();
        echo $tasks.$task.$confirm;
        break;

      case "remove":
        $task = checkInput($_POST['task']);
        $tasks = deleteTask($task, $usrnm);
        $confirm = deleteConfirm();
        echo $tasks.$confirm;
        break;

      case "video":
        break;
      default:
    }
  }

?>
