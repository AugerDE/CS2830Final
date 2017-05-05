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
                      Your notes tab is where you can add,
                      update, and delete sticky notes that
                      are perfect for jotting down important
                      info during class! Make sure you save
                      all of your changes before leaving the
                      tab!
                    </p>
                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-warning'>
                  <div class='panel-heading'>Tasks</div>
                  <div class='panel-body'>
                    <p>
                      Your tasks tab is where you can add,
                      update, and delete tasks that you
                      accumulate throughout the week. Make
                      sure to get those dates and times right,
                      wouldn't want to forget anything!
                    </p>
                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-danger'>
                  <div class='panel-heading'>Videos</div>
                  <div class='panel-body'>
                    <p>
                      Your videos tab is where you can go
                      to try and decompress from the trials
                      and tribulations from the school week.
                      You can select from funny, gaming, and
                      tech vidoes. Try not to spend too much
                      time here!
                    </p>
                  </div>
                </div>
              </div>
            </div>";
  }

?>
