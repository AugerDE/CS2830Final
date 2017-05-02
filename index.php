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
    <link rel="stylesheet" href="styles.css" />
    <script src="indexController.js"></script>
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
                      <div>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                          <input type="text" class="form-control" id="usrnm" placeholder="Username" />
                        </div>
                        <br />
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                          <input type="password" class="form-control" id="psswd" placeholder="Password" />
                        </div>
                        <br />
                        <div class="input-group">
                          <button id="login" class="btn btn-success"/>Log-In</button>
                        </div>
                      </div>
                    </div>
                    <div class="panel-footer error hidden" id="loginMessage">

                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                      <div>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                          <input type="text" class="form-control" id="email" placeholder="Email" />
                        </div>
                        <br />
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                          <input type="text" class="form-control" id="newUsrnm" placeholder="Username" />
                        </div>
                        <br />
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                          <input type="password" class="form-control" id="newPsswd" placeholder="Password" />
                        </div>
                        <br />
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                          <input type="password" class="form-control" id="psswdConf" placeholder="Confirm Password" />
                        </div>
                        <br />
                        <div class="input-group">
                          <button id="register" class="btn btn-info"/>Register</button>
                        </div>
                      </div>
                    </div>
                    <div class="panel-footer hidden" id="registerMessage">

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
