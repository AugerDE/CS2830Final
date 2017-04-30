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

  function getHomeDash(){
    return "<div class='row'>
              <div class='col-sm-4'>
                <div class='panel panel-success'>
                  <div class='panel-heading'>Check Notes</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-warning'>
                  <div class='panel-heading'>Check Tasks</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-danger'>
                  <div class='panel-heading'>Watch a Video</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
            </div>";
  }

  function getTasks($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT * FROM Tasks WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $tasks = mysqli_stmt_get_result($stmt);
    $table = "";
    $table .= "<table class='table table-striped' id='taskTable'>
                 <thead>
                   <tr>
                     <th>Username</th>
                     <th>Task Name</th>
                     <th>Task Description</th>
                     <th>Task Date</th>
                     <th>Task Time</th>
                     <th>Task Status</th>
                     <th>Update</th>
                     <th>Delete</th>
                   </tr>
                 </thead>
                <tbody>";
    while($row = $tasks->fetch_array(MYSQLI_NUM)){
      $taskDesc = "'".$row[2]."'";
      $taskDate = "'".$row[3]."'";
      $taskTime = "'".$row[4]."'";
      $taskStat = "'".$row[5]."'";
      $taskName = "'".$row[1]."'";
      $table .= "<tr>
                  <td>$row[0]</td>
                  <td>$row[1]</td>
                  <td>$row[2]</td>
                  <td>$row[3]</td>
                  <td>$row[4]</td>
                  <td>$row[5]</td>";

      $table .=  '<td>
                    <button class="btn btn-success" onclick="loadTasks('$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]')">Update</button>
                  </td>
                  </tr>';
    }
    $table .= "</tbody></table>";
    $stmt->close();
    $conn->close();
    return $table;
  }

  function editTask($task, $usrnm){
    $conn = connectToDB();
    $SQL = "SELECT taskName, taskDesc, taskDate, taskTime, TaskStat
            FROM Tasks WHERE userName=? AND taskName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $usrnm, $task);
    $stmt->execute();
    $edit = mysqli_stmt_get_result($stmt);
    $row = $edit->fetch_array(MYSQLI_NUM);
    $inputs = "<form class='form-inline' action='home.php' method='POST'>
                <div class='input-group'>
                  <input type='text' class='form-control' name='tskname' value='$row[0]' />
                  <input type='text' class='form-control' name='tskdesc' value='$row[1]' />
                  <input type='text' class='form-control' name='tskdate' value='$row[2]' />
                  <input type='text' class='form-control' name='tsktime' value='$row[3]' />
                  <input type='text' class='form-control' name='tskstat' value='$row[4]' />
                  <input type='submit' name='confirm' class='btn btn-success' value='Confirm' />
                  <input type='submit' name='cancel' class='btn btn-danger' value='Cancel' />
                </div>
               <form>";
    $stmt->close();
    $conn->close();
    return $inputs;
  }
?>
