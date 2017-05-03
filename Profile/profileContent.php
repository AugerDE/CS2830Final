<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getProfile($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT Users.userName, userMail, src, alt
            FROM Users, Pics
            WHERE Users.userName=?
            AND Pics.userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $usrnm, $usrnm);
    $stmt->execute();
    $info = mysqli_stmt_get_result($stmt);
    $row = $info->fetch_array(MYSQLI_NUM);
    $profile = "<div class='row'>
                  <div class='col-sm-3'>
                    <div class='thumbnail'>
                      <img src='$row[2]' alt='$row[3]' style='width:100%' />
                      <div class='caption'>
                        <button class='btn btn-info' onclick='showPhotos()'>Change Photo</button>
                      </div>
                    </div>
                  </div>
                  <div class='col-sm-9'>
                    <strong>Username: </strong>
                    <div class='form-inline'>
                      <input type='text' class='form-control' id='userToUpdate' disabled value='$row[0]' /> ";
    $user = "'".$usrnm."'";
    $profile .=      '<button class="btn btn-info" id="userUpdateBtn" onclick="usernameInput()">Update</button>
                      <button class="btn btn-success hidden" id="userUpdateConf" onclick="confirmUserUpdate('.$user.')">
                        <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button class="btn btn-danger hidden" id="userUpdateCanc" onclick="cancelUserUpdate('.$user.')">
                        <span class="glyphicon glyphicon-remove"></span>
                      </button>
                      <div id="usernameError" class="hidden">
                        <strong>ERROR: </strong>Invalid Username
                      </div>';
    $profile .=    "</div>
                    <br />
                    <strong>Email: </strong>
                    <div class='form-inline'>
                      <input type='text' class='form-control' id='emailToUpdate' disabled value='$row[1]' /> ";
    $email = "'".$row[1]."'";
    $profile .=       '<button class="btn btn-info" id="emailUpdateBtn" onclick="emailInput()">Update</button>
                       <button class="btn btn-success hidden" id="emailUpdateConf" onclick="confirmEmailUpdate('.$email.')">
                         <span class="glyphicon glyphicon-ok"></span>
                       </button>
                       <button class="btn btn-danger hidden" id="emailUpdateCanc" onclick="cancelEmailUpdate('.$email.')">
                         <span class="glyphicon glyphicon-remove"></span>
                       </button>
                       <div id="emailError" class="hidden">
                         <strong>ERROR: </strong>Invalid Email
                       </div>
                    </div>
                    <br />
                    <div class="form-inline hidden" id="psswdForm">
                      <strong>Current Password:</strong><br />
                      <input type="password" class="form-control" id="ogPass"/><br /><br />
                      <strong>Re-Enter Password:</strong><br />
                      <input type="password" class="form-control" id="ogPassConf"/><br /><br />
                      <strong>New Password:</strong><br />
                      <input type="password" class="form-control" id="newPass"/>
                      <button class="btn btn-success" id="passConf" onclick="confirmPassUpdate()">
                        <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button class="btn btn-danger" id="passCanc" onclick="cancelPassUpdate()">
                        <span class="glyphicon glyphicon-remove"></span>
                      </button>
                    </div>
                    <button class="btn btn-success" id="passUpdateBtn" onclick="passwordInput()">Update Password</button>
                  </div>
                </div>';
    $stmt->close();
    $conn->close();
    return $profile;
  }

  function displayPhotos(){
    $dir = "images/";
    $images = "";
    $images .= "<div class='row'><div class='col-sm-12'>";
    $i = 0;
    $images .= "<div class='col-sm-2'>";
    foreach(new DirectoryIterator($dir) as $file){
      if($file->isFile()){
        $i++;
        $location = "'Profile/".$dir.$file."'";
        $alt = "'".$file."'";
        $images .= '<button class="btnImg" onclick="changePhoto('.$location.', '.$alt.')">';
        $images .= "<img src='Profile/images/".$file."' alt=".$file." class='imgBtn' />";
        $images .= "</button>";
      }
      if($i % 3 == 0){
        $images .= "</div><div class='col-sm-2'>";
      }
    }
    $images .= "</div></div></div>";
    return $images;
  }

  function updatePhoto($src, $alt, $usrnm){
    $conn = connectToDB();
    $SQL = "UPDATE Pics
            SET src=?, alt=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("sss", $src, $alt, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return getProfile($usrnm);
  }

  function checkExists($new){
    $conn = connectToDB();
    $SQL = "SELECT * FROM Users
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return 0;
    }
    $stmt->bind_param("s", $new);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $row = $result->fetch_array(MYSQLI_NUM);
    if(empty($row[0])){
      $status = 1;
    }else{
      $status = "<strong>ERROR: </strong>This Username is Taken";
    }
    $stmt->close();
    $conn->close();
    return $status;
  }

  function updateUserName($new, $old){
    if(empty($new)){
      return "<strong>ERROR: </strong>New Username Cannot Be Empty";
    }
    if($new == $old){
      return "<strong>ERROR: </strong>New Username Cannot Be The Same";
    }
    $exists = checkExists($new);
    if($exists != 1){
      return $exists;
    }
    $conn = connectToDB();
    $SQL = "UPDATE Users
            SET userName=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $new, $old);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }

  function updateUserEmail($email, $old, $usrnm){
    if(empty($email)){
      return "<strong>ERROR: </strong>New Email Cannot Be Empty";
    }
    if($email == $old){
      return "<strong>ERROR: </strong>New Email Cannot Be The Same";
    }
    $conn = connectToDB();
    $SQL = "UPDATE Users
            SET userMail=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $email, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }

  function checkPassword($pass, $usrnm){
    $conn = connectToDB();
    $SQL = "SELECT passHash
            FROM Users
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $row = $result->fetch_array(MYSQLI_NUM);
    if(password_verify($pass, $row[0])){
      $stat = 1;
    }else{
      $stat = "<strong>ERROR: </strong>Incorrect Password";
    }
    $stmt->close();
    $conn->close();
    return $stat;
  }

  function updatePassword($pass, $pconf, $newPass, $usrnm){
    if(empty($pass) || empty($pconf) || empty($newPass)){
      return "<strong>ERROR: </strong>All Inputs Required";
    }
    if($pass != $pconf){
      return "<strong>ERROR: </strong>Passwords Don't Match";
    }
    if($newPass == $pass){
      return "<strong>ERROR: </strong>New Password Cannot Be The Same";
    }
    $stat = checkPassword($pass, $usrnm);
    if($stat != 1){
      return $stat;
    }
    $pHash = password_hash($newPass, PASSWORD_DEFAULT);
    $conn = connectToDB();
    $SQL = "UPDATE Users
            SET passHash=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = "<strong>ERROR: </strong>".$stmt->error;
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $pHash, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }
?>
