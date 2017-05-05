<?php
  include("../../secure/connect.php");
  function getContent(){
    return "<div class='row'>
              <div class='col-sm-6'>
                <div class='panel panel-default'>
                  <div class='panel-heading'>Log-In</div>
                  <div class='panel-body'>
                    <div>
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                        <input type='text' class='form-control' id='usrnm' placeholder='Username' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                        <input type='password' class='form-control' id='psswd' placeholder='Password' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <button class='btn btn-success' onclick='login()'>Log-In</button>
                      </div>
                    </div>
                  </div>
                  <div class='panel-footer hidden' id='loginMessage'>
                  </div>
                </div>
              </div>
              <div class='col-sm-6'>
                <div class='panel panel-default'>
                  <div class='panel-heading'>Register</div>
                  <div class='panel-body'>
                    <div>
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-envelope'></i></span>
                        <input type='text' class='form-control' id='email' placeholder='Email' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                        <input type='text' class='form-control' id='newUser' placeholder='Username' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                        <input type='password' class='form-control' id='newPsswd' placeholder='Password' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                        <input type='password' class='form-control' id='psswdConf' placeholder='Confirm Password' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <button class='btn btn-info' onclick='register()'>Register</button>
                      </div>
                    </div>
                  </div>
                  <div class='panel-footer hidden' id='registerMessage'>
                  </div>
                </div>
              </div>
            </div>";
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
