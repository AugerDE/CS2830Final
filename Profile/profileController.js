function profile(){
  $("#notify").hide();
  $("#home").addClass("clear");
  $("#tasks").addClass("clear");
  $("#videos").addClass("clear");
  $("#notes").addClass("clear");
  loadTab("profile");
}

function showPhotos(){
  $.post('profileHandler.php', {
    action: 'photos'
  },
  function(data){
    $("#content").html(data);
  });
}

function changePhoto(file, alt){
  $.post('profileHandler.php', {
    action: 'updatephoto',
    src: file,
    alt: alt
  },
  function(data){
    $("#content").html(data);
  });
}

function usernameInput(){
  $("#usernameError").addClass("hidden");
  $("#userToUpdate").prop("disabled", false);
  $("#userUpdateBtn").addClass("hidden");
  $("#userUpdateConf").removeClass("hidden");
  $("#userUpdateCanc").removeClass("hidden");
}

function confirmUserUpdate(user){
  var newUser = $("#userToUpdate").val();
  if(newUser != user && newUser != ""){
    $.post('profileHandler.php', {
      action: 'userupdate',
      newUser: newUser
    },
    function(data){
      $("#profile").val(newUser);
      $(".dropdown-toggle").html(newUser + " <span class='caret'></span>");
      loadTab("profile");
    });
  }else{
    $("#usernameError").removeClass("hidden");
  }
}

function cancelUserUpdate(user){
  $("#usernameError").addClass("hidden");
  $("#userToUpdate").val(user);
  $("#userToUpdate").prop("disabled", true);
  $("#userUpdateBtn").removeClass("hidden");
  $("#userUpdateConf").addClass("hidden");
  $("#userUpdateCanc").addClass("hidden");
}

function emailInput(){
  $("#emailError").addClass("hidden");
  $("#emailToUpdate").prop("disabled", false);
  $("#emailUpdateBtn").addClass("hidden");
  $("#emailUpdateConf").removeClass("hidden");
  $("#emailUpdateCanc").removeClass("hidden");
}

function cancelEmailUpdate(email){
  $("#emailError").addClass("hidden");
  $("#emailToUpdate").val(email);
  $("#emailToUpdate").prop("disabled", true);
  $("#emailUpdateBtn").removeClass("hidden");
  $("#emailUpdateConf").addClass("hidden");
  $("#emailUpdateCanc").addClass("hidden");
}

function confirmEmailUpdate(email){
  var newEmail = $("#emailToUpdate").val();
  if(newEmail != email && newEmail != ""){
    $.post('profileHandler.php', {
      action: 'emailupdate',
      newEmail: newEmail
    },
    function(data){
      loadTab("profile");
    });
  }else{
    $("#emailError").removeClass("hidden");
  }
}

function passwordInput(){
  $("#emptyPassError").addClass("hidden");
  $("#passMatchError").addClass("hidden");
  $("#passUpdateSuccess").addClass("hidden");
  $("#incorrectPass").addClass("hidden");
  $("#passUpdateBtn").addClass("hidden");
  $("#psswdForm").removeClass("hidden");
}

function cancelPassUpdate(){
  $("#ogPass").val("");
  $("#ogPassConf").val("");
  $("#newPass").val("");
  $("#emptyPassError").addClass("hidden");
  $("#passMatchError").addClass("hidden");
  $("#passUpdateSuccess").addClass("hidden");
  $("#incorrectPass").addClass("hidden");
  $("#psswdForm").addClass("hidden");
  $("#passUpdateBtn").removeClass("hidden");
}

function confirmPassUpdate(){
  $("#emptyPassError").addClass("hidden");
  $("#passMatchError").addClass("hidden");
  $("#passUpdateSuccess").addClass("hidden");
  $("#incorrectPass").addClass("hidden");
  var ogPass = $("#ogPass").val();
  var ogPassConf = $("#ogPassConf").val();
  var newPass = $("#newPass").val();
  if(ogPass == "" || ogPassConf == "" || newPass == ""){
    $("#emptyPassError").removeClass("hidden");
  }
  else if(ogPass != ogPassConf){
    $("#passMatchError").removeClass("hidden");
  }
  else if(ogPass == newPass){
    $("#incorrectPass").removeClass("hidden");
  }else{
    $.post('profileHandler.php', {
      action: 'passcheck',
      pass: ogPass,
      newPass: newPass
    },
    function(data){
      if(data == 1){
        cancelPassUpdate();
        $("#passUpdateSuccess").removeClass("hidden");
      }else{
        $("#incorrectPass").removeClass("hidden");
      }
    });
  }
}