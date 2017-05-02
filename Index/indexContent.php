<?php
  function getContent(){
    return "<div class='row'>

              <div class='col-sm-6'>
                <div class='panel panel-default'>
                  <div class='panel-heading'>Log-In</div>
                  <div class='panel-body'>
                    <div>
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                        <input type='text' class='form-control' id='usrnm' placeholder='Username' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                        <input type='password' class='form-control' id='psswd' placeholder='Placeholder' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <button class='btn btn-success' onclick='login()'>Log-In</button>
                      </div>
                    </div>
                  </div>
                  <div class='panel-footer hidden' id='loginMessage'>
                  </div>
                </div>
              </div>

              <div class='col-sm-6'>
                <div class='panel panel-default'>
                  <div class='panel-heading'>Register</div>
                  <div class='panel-body'>
                    <div>
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-envelope'></i></span>
                        <input type='text' class='form-control' id='email' placeholder='Email' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                        <input type='text' class='form-control' id='newUser' placeholder='Username' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                        <input type='password' class='form-control' id='newPsswd' placeholder='Password' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                        <input type='password' class='form-control' id='psswdConf' placeholder='Confirm Password' />
                      </div>
                      <br />
                      <div class='input-group'>
                        <button class='btn btn-info' onclick='register()'>Register</button>
                      </div>
                    </div>
                  </div>
                  <div class='panel-footer hidden' id='registerMessage'>
                  </div>
                </div>
              </div>

            </div>";
  }
?>
