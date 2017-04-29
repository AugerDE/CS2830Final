<?php
  include("../secure/connect.php");
  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function login($usrnm, $psswd){
    if(empty($usrnm) || empty($psswd)){
      return emptyFormMessage();
    }
    $conn = connectToDB();
    $SQL = "SELECT * FROM Users WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
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
      $status = loginFailMessage();
    }
    $stmt->close();
    $conn->close();
    return $status;
  }

  function register($email, $usrnm, $psswd, $pconf){
    if(empty($email) || empty($usrnm) || empty($psswd) || empty($pconf)){
      return emptyFormMessage();
    }
    if($psswd != $pconf){
      return passwordFailMessage();
    }
    $conn = connectToDB();
    $SQL = "SELECT * FROM Users WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $output = mysqli_stmt_get_result($stmt);
    $row = $output->fetch_array(MYSQLI_NUM);
    if($row[0] == $usrnm){
      $status = registerFailMessage();
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
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("sss", $usrnm, $phash, $email);
    $stmt->execute();
    $stmt->close();
    return 1;
  }

  function emptyFormMessage(){
    return "<div class='panel-footer'>
              <strong>ERROR: </strong>All Fields Required
            </div>";
  }

  function loginFailMessage(){
    return "<div class='panel-footer'>
              <strong>ERROR: </strong>Incorrect Username or Password
            </div>";
  }

  function passwordFailMessage(){
    return "<div class='panel-footer'>
              <strong>ERROR: </strong>Passwords Don't Match
            </div>";
  }

  function registerFailMessage(){
    return "<div class='panel-footer'>
              <strong>ERROR: </strong>This Username is Already Taken
            </div>";
  }

  function registerSuccessMessage(){
    return "<div class='panel-footer'>
              <strong>USER CREATED: </strong>Now Just Log-In!
            </div>";
  }

  function stmtErrorMessage($error){
    return "<div class='panel-footer'>
              <strong>ERROR: </strong>".$error."
            </div>";
  }
?>
