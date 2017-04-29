<?php
  session_start();
  ob_start();

  if(!isset($_SESSION['status'])){
    session_unset();
    session_destroy();
    header('Location: index.php');
  }

  $usrnm = (isset($_SESSION['user']) ? $_SESSION['user'] : NULL);

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
    <div class="container">

      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">DEAYQF</a>
          </div>
          <ul class="nav navbar-nav">
            <button id="home" class="btn btn-default navbar-btn">Home</button>
          </ul>
          <ul class="nav navbar-nav">
            <button id="notes" class="btn btn-success navbar-btn">Notes</button>
            <button id="tasks" class="btn btn-warning navbar-btn">Tasks</button>
            <button id="videos" class="btn btn-danger navbar-btn">Videos</button>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><button id="profile" class="btn btn-info navbar-btn" value="<?=$usrnm?>"></button></li>
            <li><form action="home.php" method="POST">
              <input type="submit" name="logout" class="btn btn-danger navbar-btn" value="Logout" />
            </form></li>
          </ul>
        </div>
      </nav>

      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
            <div class="panel-heading"><h2>Welcome back, <?=$_SESSION['user']?>!</h2></div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-4">
                  <div class="panel panel-success">
                    <div class="panel-heading">Check Notes</div>
                    <div class="panel-body">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="panel panel-warning">
                    <div class="panel-heading">Check Tasks</div>
                    <div class="panel-body">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="panel panel-danger">
                    <div class="panel-heading">Watch a Video</div>
                    <div class="panel-body">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
  </body>
</html>
