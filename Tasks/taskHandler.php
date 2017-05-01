<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['user'])){
    session_unset();
    session_destroy();
    header('Location: ../index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  include("taskContent.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "tasks":
        $tasks = getTasks($usrnm);
        echo $tasks;
        break;

      case "update":
        $task = checkInput($_POST['task']);
        $name = checkInput($_POST['name']);
        $desc = checkInput($_POST['desc']);
        $date = checkInput($_POST['date']);
        $time = checkInput($_POST['time']);
        $stat = checkInput($_POST['stat']);
        updateTask($task, $name, $desc, $date, $time, $stat, $usrnm);
        $tasks = getTasks($usrnm);
        echo $tasks;
        break;

      case "remove":
        $task = checkInput($_POST['task']);
        deleteTask($task, $usrnm);
        $tasks = getTasks($usrnm);
        echo $tasks;
        break;

      case "add":
        $name = checkInput($_POST['name']);
        $desc = checkInput($_POST['desc']);
        $date = checkInput($_POST['date']);
        $time = checkInput($_POST['time']);
        $stat = checkInput($_POST['stat']);
        addTask($name, $desc, $date, $time, $stat, $usrnm);
        $tasks = getTasks($usrnm);
        echo $tasks;
        break;
    }
  }
?>
