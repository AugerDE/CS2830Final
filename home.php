<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: index.php');
  }

  include("functions.php");

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);
  $tab = (isset($_SESSION['tab']) ? $_SESSION['tab'] : NULL);

  if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header('Location: index.php');
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css" />
    <script src="scripts.js"></script>
  </head>
  <body>
    <input type='hidden' id="profile" value="<?=$usrnm?>">
    <div class="container">

      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">DEAYQF</a>
          </div>
          <ul class="nav navbar-nav">
            <button id="home" class="btn btn-default navbar-btn">Home</button>
            <button id="notes" class="btn btn-success navbar-btn clear">Notes</button>
            <button id="tasks" class="btn btn-warning navbar-btn clear">Tasks</button>
            <button id="videos" class="btn btn-danger navbar-btn clear">Videos</button>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span> 
                  <strong><?=$usrnm?></strong>
                <span class="glyphicon glyphicon-chevron-down"></span>
              </a>
              <ul style="background-color:white; opacity:0.9;" class="dropdown-menu">
                <li>
                  <button class="btn btn-info navbar-btn" id="profile" value="<?=$usrnm?>">
                    <span class="glyphicon glyphicon-user"></span>
                  </button>
                </li>
                <li class="divider"></li>
                <li>
                  <div class="navbar-login navbar-login-session">
                    <div class="row">
                      <div class="col-lg-12">
                        <p>
                          <form action="home.php" method="POST">
                            <input type="submit" name="logout" class="btn btn-danger navbar-btn" value="Logout" />
                          </form>
                        </p>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info" id="panelType">
            <div class="panel-heading"><h2 id="contentHeader"></h2></div>
            <div class="panel-body" id="content">

            </div>
            <div id="notify"></div>
          </div>
        </div>
      </div>



    </div>
  </body>
</html>
