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
                    <p>
                      This is where you will find your sticky
                      notes! They can be updated, deleted and
                      moved around. Be warned that any changes
                      will be discarded if not saved.
                    </p>
                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-warning'>
                  <div class='panel-heading'>Tasks</div>
                  <div class='panel-body'>
                    <p>
                      This is your task table! You can add,
                      update, and delete any task at any time.
                      Make sure you have all of the forms
                      filled out before updating or adding a
                      task.
                    </p>
                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-danger'>
                  <div class='panel-heading'>Videos</div>
                  <div class='panel-body'>
                    <p>
                      These are your videos! You can come
                      here at any time to decompress from the
                      stress of school work. You can choose
                      between funny, gaming, and tech videos!
                    </p>
                  </div>
                </div>
              </div>
            </div>";
  }

?>
