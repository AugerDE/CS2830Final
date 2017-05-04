<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes($usrnm){
    $conn = connectToDB();
    $SQL = "SELECT noteCont
            FROM Notes
            WHERE userName=?";
    $stmt = $conn->stmt_init();
    if($stmt->prepare($SQL)){
      exit();
    }
    $stmt->bind_param("s", $usrnm);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    $notes = "";
    while($row = $result->fetch_array(MYSQLI_NUM)){
      $notes .= "<div class='notes'>
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
?>
