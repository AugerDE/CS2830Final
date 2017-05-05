<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: index.php');
  }

  if(isset($_POST['action'])){
    $action = $_POST['action'];
    switch($action){
      case "load":
        echo getHomeDash();
        break;
    }
  }

  function getHomeDash(){
    return "<div class='row'>
              <div class='col-sm-4'>
                <div class='panel panel-success'>
                  <div class='panel-heading'>Notes</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-warning'>
                  <div class='panel-heading'>Tasks</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-danger'>
                  <div class='panel-heading'>Videos</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
            </div>";
  }

?>
