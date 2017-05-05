<?php
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
        echo getVideo();
        break;
    }
  }

  function getVideo(){
    $thumb = "https://img.youtube.com/vi/4TnQ99ESoKM/mqdefault.jpg";
    $link = "https://www.youtube.com/embed/4TnQ99ESoKM";

    $imgsrc = "'".$thumb."'";
    $vidsrc = "'".$link."'";

    $vid = "<div class='col-sm-2'>";
    $vid .= '<button class="vidImg" onclick="changeVideo('.$imgsrc.', '.$vidsrc.')">';
    $vid .= "<img src='".$thumb."' class='vidBtn img-rounded' />
             </button></div>
             <iframe id='vidPlayer' src='' height='500' width='600' class='hidden' allowfullscreen></iframe>";

    return $vid;
  }
?>
