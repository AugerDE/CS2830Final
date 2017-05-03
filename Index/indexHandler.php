<?php
  session_start();
  ob_start();

  include("../../secure/connect.php");
  include("indexContent.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "content":
        echo getContent();
        break;

      case "login":
        $usrnm = checkInput($_POST['usrnm']);
        $psswd = checkInput($_POST['psswd']);
        $status = login($usrnm, $psswd);
        if($status == 1){
          $_SESSION['user'] = $usrnm;
          $_SESSION['status'] = "active";
          echo $status;
        }else{
          echo $status;
        }
        break;

      case "register":
        $email = checkInput($_POST['email']);
        $usrnm = checkInput($_POST['usrnm']);
        $psswd = checkInput($_POST['psswd']);
        $pconf = checkInput($_POST['pconf']);
        $status = register($email, $usrnm, $psswd, $pconf);
        if($status == 1){
          $_SESSION['user'] = $usrnm;
          $_SESSION['status'] = "active";
          echo $status;
        }else{
          echo $status;
        }
        break;
    }
  }

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function login($usrnm, $psswd){
    if(empty($usrnm) || empty($psswd)){
      return "<strong>ERROR: </strong>All Inputs Required";
    }
    $conn = connectToDB();
    $SQL = "SELECT * FROM Users WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $output = mysqli_stmt_get_result($stmt);
    $row = $output->fetch_array(MYSQLI_NUM);
    if($row[0] == $usrnm && password_verify($psswd, $row[1])){
      $status = 1;
    }else{
      $status = "<strong>ERROR: </strong>Incorrect Username or Password";
    }
    $stmt->close();
    $conn->close();
    return $status;
  }

  function register($email, $usrnm, $psswd, $pconf){
    if(empty($email) || empty($usrnm) || empty($psswd) || empty($pconf)){
      return "<strong>ERROR: </strong>All Inputs Required";
    }else if($psswd != $pconf){
      return "<strong>ERROR: </strong>Passwords Don't Match";
    }
    $conn = connectToDB();
    $SQL = "SELECT * FROM Users WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $output = mysqli_stmt_get_result($stmt);
    $row = $output->fetch_array(MYSQLI_NUM);
    if($row[0] == $usrnm){
      $status = "<strong>ERROR: </strong>This Username is Taken";
    }else{
      $status = addUser($email, $usrnm, $psswd, $conn);
    }
    $stmt->close();
    $conn->close();
    return $status;
  }

  function addUser($email, $usrnm, $psswd, $conn){
    $phash = password_hash($psswd, PASSWORD_DEFAULT);
    $SQL = "INSERT INTO Users(userName, passHash, userMail)
            VALUES(?, ?, ?)";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("sss", $usrnm, $phash, $email);
    $stmt->execute();
    $stmt->close();
    return addPic($usrnm, $conn);
  }

  function addPic($usrnm, $conn){
    $src = "Profile/images/cool.gif";
    $alt = "cool.gif";
    $SQL = "INSERT INTO Pics(userName, src, alt)
            VALUES(?, ?, ?)";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("sss", $usrnm, $src, $alt);
    $stmt->execute();
    $stmt->close();
    return 1;
  }
?>
