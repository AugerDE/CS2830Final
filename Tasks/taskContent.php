<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getTasks($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT taskName, taskDesc, taskDate, taskTime, TaskStat
            FROM Tasks WHERE userName=?";
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
    if(empty($tasks)){
      $stmt->close();
      $conn->close();
      return emptyTaskTable();
    }
    $table = "";
    $table .= "<table class='table table-striped' id='taskTable'>
                 <thead>
                   <tr>
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
      $taskName = "'".$row[0]."'";
      $taskDesc = "'".$row[1]."'";
      $taskDate = "'".$row[2]."'";
      $taskTime = "'".$row[3]."'";
      $taskStat = "'".$row[4]."'";
      $table .= "<tr>
                  <td>$row[0]</td>
                  <td>$row[1]</td>
                  <td>$row[2]</td>
                  <td>$row[3]</td>
                  <td>$row[4]</td>";

      $table .=  '<td>
                    <button class="btn btn-success" onclick="editTask('.$taskName.', '.$taskDesc.', '.$taskDate.', '.$taskTime.', '.$taskStat.')">Update</button>
                  </td>
                  <td>
                    <button class="btn btn-danger" onclick="deleteTask('.$taskName.', '.$taskDesc.', '.$taskDate.', '.$taskTime.', '.$taskStat.')">Delete</button>
                  </td>
                  </tr>';
    }
    $table .= "</tbody></table>
               <div id='addBtn'>
                 <button class='btn btn-success' id='addTaskBtn' onclick='addForm()'>
                   <span class='glyphicon glyphicon-plus'></span> Add a Task
                 </button>
               </div>

               <div class='form-inline hidden' id='addTaskForm'>
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
               </div>

               <div class='form-inline hidden' id='editTaskForm'>
                 <input type='hidden' id='task'/>
                 <th><input type='text' class='form-control' id='name'/></th>
                 <th><input type='text' class='form-control' id='desc'/></th>
                 <th><input type='text' class='form-control' id='date'/></th>
                 <th><input type='text' class='form-control' id='time'/></th>
                 <th><input type='text' class='form-control' id='stat'/></th>
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
               </div>

               <div class='form-inline hidden' id='deleteTaskForm'>
                 <input type='hidden' id='deltask'/>
                 <th><input disabled type='text' class='form-control' id='delname'/></th>
                 <th><input disabled type='text' class='form-control' id='deldesc'/></th>
                 <th><input disabled type='text' class='form-control' id='deldate'/></th>
                 <th><input disabled type='text' class='form-control' id='deltime'/></th>
                 <th><input disabled type='text' class='form-control' id='delstat'/></th>
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
               </div>";

    $stmt->close();
    $conn->close();
    return $table;
  }

  function deleteTask($task, $usrnm){
    $conn = connectToDB();
    $SQL = "DELETE FROM Tasks
            WHERE taskName=?
            AND userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ss", $task, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }

  function addTask($name, $desc, $date, $time, $stat, $usrnm){
    $conn = connectToDB();
    $SQL = "INSERT INTO Tasks(userName, taskName, taskDesc, taskDate, taskTime, taskStat)
            VALUES(?, ?, ?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("ssssss", $usrnm, $name, $desc, $date, $time, $stat);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }

  function updateTask($task, $name, $desc, $date, $time, $stat, $usrnm){
    $conn = connectToDB();
    $SQL = "UPDATE Tasks
            SET taskName=?, taskDesc=?, taskDate=?, taskTime=?, taskStat=?
            WHERE taskName=?
            AND userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $error = stmtErrorMessage($stmt->error);
      $stmt->close();
      $conn->close();
      return $error;
    }
    $stmt->bind_param("sssssss", $name, $desc, $date, $time, $stat, $task, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }

  function emptyTaskTable(){
    return "<table class='table table-striped' id='emptyTable'>
              <thead>
                <tr>
                  <th>It Looks Like You Don't Have Any Tasks Yet!</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Press the Add a Task Button to get started</td>
                </tr>
              </tbody>
            </table>
            <div class='form-inline hidden' id='addTaskForm'>
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

?>
