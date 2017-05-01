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
      case "photos":
        echo displayPhotos();
        break;

      case "updatephoto":
        $src = checkInput($_POST['src']);
        $alt = checkInput($_POST['alt']);
        echo updatePhoto($src, $alt, $usrnm);
        break;

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

      case "userupdate":
        $new = checkInput($_POST['newUser']);
        echo updateUserName($new, $usrnm);
        $_SESSION['user'] = $new;
        break;

      case "emailupdate":
        $email = checkInput($_POST['newEmail']);
        echo updateUserEmail($email, $usrnm);
        break;

      case "notes":
        break;

      case "tasks":
        $tasks = getTasks($usrnm);
        $new = addTaskButton();
        echo $tasks.$new;
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
        if(empty($name) || empty($desc) || empty($date) || empty($time) || empty($stat)){
          echo "empty";
        }else{
          updateTask($task, $name, $desc, $date, $time, $stat, $usrnm);
          $tasks = getTasks($usrnm);
          $new = addTaskButton();
          echo $tasks.$new;
        }
        break;

      case "delete":
        $name = checkInput($_POST['name']);
        $tasks = getTasks($usrnm);
        $task = taskToDelete($name, $usrnm);
        echo $tasks.$task;
        break;

      case "remove":
        $task = checkInput($_POST['task']);
        deleteTask($task, $usrnm);
        $tasks = getTasks($usrnm);
        $new = addTaskButton();
        echo $tasks.$new;
        break;

      case "showadd":
        $tasks = getTasks($usrnm);
        $form = addTaskForm();
        echo $tasks.$form;
        break;

      case "add":
        $name = checkInput($_POST['name']);
        $desc = checkInput($_POST['desc']);
        $date = checkInput($_POST['date']);
        $time = checkInput($_POST['time']);
        $stat = checkInput($_POST['stat']);
        if(empty($name) || empty($desc) || empty($date) || empty($time) || empty($stat)){
          echo "empty";
        }else{
          addTask($name, $desc, $date, $time, $stat, $usrnm);
          $tasks = getTasks($usrnm);
          $new = addTaskButton();
          echo $tasks.$new;
        }
        break;

      case "video":
        break;
      default:
    }
  }

?>
