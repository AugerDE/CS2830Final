<?php
  include("../../secure/connect.php");
  function getProfile($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT Users.userName, userMail, src, alt
            FROM Users, Pics
            WHERE Users.userName=?
            AND Pics.userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
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
                      <input type="password" class="form-control" id="ogPass" placeholder="Password"/><br /><br />
                      <strong>Re-Enter Password:</strong><br />
                      <input type="password" class="form-control" id="ogPassConf" placeholder="Confirm Password"/><br /><br />
                      <strong>New Password:</strong><br />
                      <input type="password" class="form-control" id="newPass" placeholder="New Password"/>
                      <button class="btn btn-success" id="passConf" onclick="confirmPassUpdate()">
                        <span class="glyphicon glyphicon-ok"></span>
                      </button>
                      <button class="btn btn-danger" id="passCanc" onclick="cancelPassUpdate()">
                        <span class="glyphicon glyphicon-remove"></span>
                      </button>
                    </div>
                    <button class="btn btn-success" id="passUpdateBtn" onclick="passwordInput()">Update Password</button>
                    <div id="emptyPassError" class="hidden">
                      <strong>ERROR: </strong>All Inputs Required
                    </div>
                    <div id="passMatchError" class="hidden">
                      <strong>ERROR: </strong>Passwords Do Not Match
                    </div>
                    <div id="incorrectPass" class="hidden">
                      <strong>ERROR: </strong>Incorrect Password
                    </div>
                    <div id="passUpdateSuccess" class="hidden">
                      Password Successfully Updated
                    </div>
                  </div>
                </div>';
    $stmt->close();
    $conn->close();
    return $profile;
  }

  function displayPhotos(){
    $dir = "../images/";
    $images = "";
    $images .= "<div class='row'><div class='col-sm-12'>";
    $i = 0;
    $images .= "<div class='col-sm-2'>";
    foreach(new DirectoryIterator($dir) as $file){
      if($file->isFile()){
        $i++;
        $location = "'".$dir.$file."'";
        $alt = "'".$file."'";
        $images .= '<button class="btnImg" onclick="changePhoto(../'.$location.', '.$alt.')">';
        $images .= "<img src='../images/".$file."' alt=".$file." class='imgBtn' />";
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
      $error = stmtErrorMessage($stmt->error);
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

  function updateUserName($new, $old){
    $conn = connectToDB();
    $SQL = "UPDATE Users
            SET userName=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $new, $old);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return getProfile($new);
  }

  function updateUserEmail($email, $usrnm){
    $conn = connectToDB();
    $SQL = "UPDATE Users
            SET userMail=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $email, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return getProfile($usrnm);
  }

  function checkPassword($pass, $usrnm){
    $conn = connectToDB();
    $SQL = "SELECT passHash
            FROM Users
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
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
      $stat = 0;
    }
    $stmt->close();
    $conn->close();
    return $stat;
  }

  function updatePassword($newPass, $usrnm){
    $pHash = password_hash($newPass, PASSWORD_DEFAULT);
    $conn = connectToDB();
    $SQL = "UPDATE Users
            SET passHash=?
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
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
