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
      $x = "'".$row[1]."'";
      $y = "'".$row[2]."'";
      $cont = "'".$row[0]."'";
      $notes .= "<div class='notes' style='top:$row[1]; left:$row[2];'>";
      $notes .=   '<button class="btn btn-sm btn-danger closeNote" onclick="deleteNote('.$y.', '.$x.', '.$cont.')">';
      $notes .=     "<span class='glyphicon glyphicon-remove'></span>
                   </button>";
      $notes .=   "<textarea spellcheck='false'>$row[0]</textarea>
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
    $conn = connectToDB();
    $SQL = "INSERT INTO Notes(userName, noteCont, y, x)
            VALUES(?, ?, '0px', '0px')";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("ss", $usrnm, $cont);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    return 1;
  }

  function deleteNote($x, $y, $cont, $usrnm){
    $conn = connectToDB();
    $SQL = "DELETE FROM Notes
            WHERE noteCont=? AND userName=?";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->bind_param("ss", $cont, $usrnm);
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

  function saveNote($cont, $x, $y, $usrnm){
    $conn = connectToDB();
    $SQL = "INSERT INTO Notes(userName, noteCont, x, y)
            VALUES(?, ?, ?, ?)";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      exit();
    }
    $x = $x."px";
    $y = $y."px";
    $stmt->bind_param("ssss", $usrnm, $cont, $x, $y);
    $stmt->execute();
    $stmt->close();
    $conn->close();
  }
?>
