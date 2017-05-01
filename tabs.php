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
      case "empty":
        echo emptyFormMessage();
        break;

      case "updatesuccess":
        echo updateMessage();
        break;

      case "addsuccess":
        echo addMessage();
        break;

      case "deletesuccess":
        echo deleteMessage();
        break;

      case "profile":
        echo getProfile($usrnm);
        break;

      case "home":
        echo getHomeDash();
        break;

      case "notes":
        break;



      case "edit":
        $name = checkInput($_POST['name']);
        $tasks = getTasks($usrnm);
        $task = editTask($name, $usrnm);
        echo $tasks.$task;
        break;



      case "delete":
        $name = checkInput($_POST['name']);
        $tasks = getTasks($usrnm);
        $task = taskToDelete($name, $usrnm);
        echo $tasks.$task;
        break;



      case "showadd":
        $tasks = getTasks($usrnm);
        $form = addTaskForm();
        echo $tasks.$form;
        break;

      

      case "video":
        break;
      default:
    }
  }

?>
