<?php
  include("functions.php");

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    $usrnm = checkInput($_POST['usrnm']);
    switch($action){
      case "notes":
        break;
      case "tasks":
        getTasks($usrnm);
        break;
      case "video":
        break;
      default:
    }
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
    $table .= "<table>
                 <thead>
                   <tr>
                     <th>Username</th>
                     <th>Task Name</th>
                     <th>Task Description</th>
                     <th>Task Date</th>
                     <th>Task Time</th>
                     <th>Task Status</th>
                   </tr>
                 </thead>
                <tbody>";
    while($row = $tasks->fetch_array(MYSQLI_NUM)){
      $table .= "<tr>
                  <td>$row[0]</td>
                  <td>$row[1]</td>
                  <td>$row[2]</td>
                  <td>$row[3]</td>
                  <td>$row[4]</td>
                  <td>$row[5]</td>
                </tr>";
    }
    $table .= "</tbody></table>";
    $stmt->close();
    $conn->close();
    echo $table;
  }
?>
