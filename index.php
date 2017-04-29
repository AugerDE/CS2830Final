<?php
  include("functions.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">

      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="#">DEAYQF</a>
          </div>
        </div>
      </nav>

      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-info">
            <div class="panel panel-heading"><h2>Final Project</h2></div>
            <div class="panel-body">

              <div class="row">
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">Log-In</div>
                    <div class="panel-body">
                      <form action="index.php" method="POST">
                        <div>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="usrnm" placeholder="Username" />
                          </div>
                          <br />
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" name="psswd" placeholder="Password" />
                          </div>
                          <br />
                          <div class="input-group">
                            <input type="submit" name="login" class="btn btn-success" value="Log-In" />
                          </div>
                        </div>
                      </form>
                    </div>
                    <?php
                      if(isset($_POST['login'])){
                        $usrnm = checkInput($_POST['usrnm']);
                        $psswd = checkInput($_POST['psswd']);
                        $status = login($usrnm, $psswd);
                        if($status == 1){
                          session_start();
                          ob_start();
                          $_SESSION['user'] = $usrnm;
                          $_SESSION['status'] = "active";
                          header('Location: home.php');
                        }else{
                          echo $status;
                        }
                      }
                    ?>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                      <form action="index.php" method="POST">
                        <div>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" class="form-control" name="email" placeholder="Email" />
                          </div>
                          <br />
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="usrnm" placeholder="Username" />
                          </div>
                          <br />
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" name="psswd" placeholder="Password" />
                          </div>
                          <br />
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" name="pconf" placeholder="Confirm Password" />
                          </div>
                          <br />
                          <div class="input-group">
                            <input type="submit" name="register" class="btn btn-info" value="Register" />
                          </div>
                        </div>
                      </form>
                    </div>
                    <?php
                      if(isset($_POST['register'])){
                        $email = checkInput($_POST['email']);
                        $usrnm = checkInput($_POST['usrnm']);
                        $psswd = checkInput($_POST['psswd']);
                        $pconf = checkInput($_POST['pconf']);
                        $status = register($email, $usrnm, $psswd, $pconf);
                        if($status == 1){
                          echo registerSuccessMessage();
                        }else{
                          echo $status;
                        }
                      }
                    ?>
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
