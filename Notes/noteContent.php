<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT noteID, noteCont, y, x
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
      $y = $row[2]."px";
      $x = $row[3]."px";
      $id = "'".$row[0]."'";
      $notes .= "<div class='notes' style='top:$y; left:$x;'>";
      $notes .=   '<button class="btn btn-sm btn-danger closeNote" onclick="deleteNote('.$id.')">';
      $notes .=     "<span class='glyphicon glyphicon-remove'></span>
                   </button>";
      $notes .=   "<textarea spellcheck='false'>$row[1]</textarea>
                 </div>";
    }
    $stmt->close();
    $conn->close();
    return $notes;
  }

  function getNoteNum($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT * FROM Notes WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      exit();
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $i = 1;
    while($row = $result->fetch_array(MYSQLI_NUM)){
      $i++;
    }
    $stmt->close();
    $conn->close();
    return $i;
  }

  function addNote($usrnm){
    $num = getNoteNum($usrnm);
    $cont = "New Note ".$num;
    $fix = -800;
    $conn = connectToDB();
    $SQL = "INSERT INTO Notes(noteID, userName, noteCont, y, x)
            VALUES(?, ?, ?, ?, 0.0)";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("issd", $num, $usrnm, $cont, $fix);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }

  function deleteNote($id, $usrnm){
    $conn = connectToDB();
    $SQL = "DELETE FROM Notes
            WHERE noteID=? AND userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("is", $id, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }

  function clearNotes($usrnm){
    $conn = connectToDB();
    $DEL = "DELETE FROM Notes WHERE userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($DEL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $stmt->close();
    return 1;
  }

  function saveNote($old, $new, $x, $y, $usrnm){
    $x = $x."px";
    $y = $y."px";
    $conn = connectToDB();
    $SQL = "UPDATE Notes
            SET noteCont=?, y=?, x=?
            WHERE noteCont=? AND userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("sssss", $new, $y, $x, $old, $usrnm);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }
?>
