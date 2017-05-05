<?php
  
  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function emptyFormMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>All Fields Required
            </div>";
  }

  function loginFailMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>Incorrect Username or Password
            </div>";
  }

  function passwordFailMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>Passwords Don't Match
            </div>";
  }

  function registerFailMessage(){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>This Username is Already Taken
            </div>";
  }

  function registerSuccessMessage(){
    return "<div class='panel-footer good'>
              <strong>USER CREATED: </strong>Now Just Log-In!
            </div>";
  }

  function stmtErrorMessage($error){
    return "<div class='panel-footer error'>
              <strong>ERROR: </strong>".$error."
            </div>";
  }

  function getHomeDash(){
    return "<div class='row'>
              <div class='col-sm-4'>
                <div class='panel panel-success'>
                  <div class='panel-heading'>Check Notes</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-warning'>
                  <div class='panel-heading'>Check Tasks</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
              <div class='col-sm-4'>
                <div class='panel panel-danger'>
                  <div class='panel-heading'>Watch a Video</div>
                  <div class='panel-body'>

                  </div>
                </div>
              </div>
            </div>";
  }

?>
