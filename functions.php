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
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>All Fields Required
            </div>";
  }

  function loginFailMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>Incorrect Username or Password
            </div>";
  }

  function passwordFailMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>Passwords Don't Match
            </div>";
  }

  function registerFailMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>This Username is Already Taken
            </div>";
  }

  function registerSuccessMessage(){
    return "<div class='panel-footer good'>
              <strong>USER CREATED: </strong>Now Just Log-In!
            </div>";
  }

  function stmtErrorMessage($error){
    return "<div class='panel-footer error'>
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



  function addTaskButton(){
    return "<div id='addBtn'>
              <button class='btn btn-success' onclick='addForm()'>
                <span class='glyphicon glyphicon-plus'></span> Add a Task
              </button>
            </div>";
  }

  function addTaskForm(){
    return "<div class='form-inline'>
              <th><input type='text' class='form-control' id='tskname' placeholder='Task Name'/></th>
              <th><input type='text' class='form-control' id='tskdesc' placeholder='Task Description'/></th>
              <th><input type='text' class='form-control' id='tskdate' placeholder='Task Date'/></th>
              <th><input type='text' class='form-control' id='tsktime' placeholder='Task Time'/></th>
              <th><input type='text' class='form-control' id='tskstat' placeholder='Task Status'/></th>
              <th>
                <button class='btn btn-success' onclick='addTask()'>
                  <span class='glyphicon glyphicon-plus'></span>
                </button>
              </th>
              <th>
                <button class='btn btn-danger' onclick='cancel()'>
                  <span class='glyphicon glyphicon-remove'></span>
                </button>
              </th>
            </div>";
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
    $inputs = "<div class='form-inline'>
                <input type='hidden' id='task' value='$task' />
                <th><input type='text' class='form-control' id='tskname' value='$row[0]' /></th>
                <th><input type='text' class='form-control' id='tskdesc' value='$row[1]' /></th>
                <th><input type='text' class='form-control' id='tskdate' value='$row[2]' /></th>
                <th><input type='text' class='form-control' id='tsktime' value='$row[3]' /></th>
                <th><input type='text' class='form-control' id='tskstat' value='$row[4]' /></th>
                <th>
                  <button class='btn btn-info' onclick='updateTask()'>
                    <span class='glyphicon glyphicon-ok'></span>
                  </button>
                </th>
                <th>
                  <button class='btn btn-danger' onclick='cancel()'>
                    <span class='glyphicon glyphicon-remove'></span>
                  </button>
                </th>
               <div>";
    $stmt->close();
    $conn->close();
    return $inputs;
  }



  function taskToDelete($task, $usrnm){
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
    $inputs = "<div class='form-inline'>
                <input type='hidden' id='task' value='$task' />
                <th><input disabled type='text' class='form-control' id='tskname' value='$row[0]' /></th>
                <th><input disabled type='text' class='form-control' id='tskdesc' value='$row[1]' /></th>
                <th><input disabled type='text' class='form-control' id='tskdate' value='$row[2]' /></th>
                <th><input disabled type='text' class='form-control' id='tsktime' value='$row[3]' /></th>
                <th><input disabled type='text' class='form-control' id='tskstat' value='$row[4]' /></th>
                <th>
                  <button class='btn btn-info' onclick='removeTask()'>
                    <span class='glyphicon glyphicon-ok'></span>
                  </button>
                </th>
                <th>
                  <button class='btn btn-danger' onclick='cancel()'>
                    <span class='glyphicon glyphicon-remove'></span>
                  </button>
                </th>
               <div>";
    $stmt->close();
    $conn->close();
    return $inputs;
  }



  function updateMessage(){
    return "<div class='panel-footer good'>
              Task Successfully Updated
            </div>";
  }

  function addMessage(){
    return "<div class='panel-footer good'>
              Task Successfully Added
            </div>";
  }

  function deleteMessage(){
    return "<div class='panel-footer good'>
              Task Successfully Deleted
            </div>";
  }
?>
