<?php
  include("../../secure/connect.php");
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: ../index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

  if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch($action){
      case "load":
        echo getGenres();
        break;
    }
  }

  function getGenres(){
    return '<div class="form-inline" id="genreHolder">
              <button class="btn btn-info" onclick="getFunny()">Funny</button>
              <button class="btn btn-info">Gaming</button>
              <button class="btn btn-info">Tech</button>
            </div>';
  }

  function getVideos(){
    $conn = connectToDB();
    $SQL = "SELECT thumb, src FROM Videos WHERE genre='funny'";
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($SQL)){
      $stmt->close();
      $conn->close();
      return $stmt->error;
    }
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);

    $vids = "<div class='row' id='vidBtnHolder'><div class='col-sm-12'>";
    while($row = $result->fetch_array(MYSQLI_NUM)){
      $imgsrc = "'".$row[0]."'";
      $vidsrc = "'".$row[1]."'";
      $vids .= "<div class='col-sm-2'>";
      $vids .= '<button class="vidImg" onclick="changeVideo('.$imgsrc.', '.$vidsrc.')">';
      $vids .= "<img src='".$row[0]."' class='vidBtn img-rounded' />
               </button></div>";
    }
    $vids .= "</div></div>";
    $vids .= "<iframe id='vidPlayer' src='' height='500' width='600' class='hidden' allowfullscreen></iframe>";
    $vids .= '<button class="btn btn-success" onclick="hideVideo()">Change Video</button>';
    $stmt->close();
    $conn->close();
    return $vids;
  }
?>
