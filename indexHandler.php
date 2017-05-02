<?php
  session_start();
  ob_start();

  include("../secure/connect.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
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
    }
  }

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function login($usrnm, $psswd){
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
?>
