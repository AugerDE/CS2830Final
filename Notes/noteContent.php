<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT noteCont, y, x
            FROM Notes
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $notes = "";
    while($row = $result->fetch_array(MYSQLI_NUM)){
      $notes .= "<div class='notes' style='top:$row[1]; left:$row[2];'>
                   <button class='btn btn-sm btn-danger closeNote'>
                     <span class='glyphicon glyphicon-remove'></span>
                   </button>
                   <textarea spellcheck='false'>$row[0]</textarea>
                 </div>";
    }
    $stmt->close();
    $conn->close();
    return $notes;
  }

  function addNote($usrnm){
    $conn = connectToDB();
    $SQL = "INSERT INTO Notes
            VALUES(userName, noteCont, y, x)
            VALUES(?, 'New Note', '0px', '0px')";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }
?>
