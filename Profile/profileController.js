function loadProfile(){
  $.post('Profile/profileHandler.php', {
    action: "profile"
  },
  function(data){
    $("#content").html(data);
    var user = $("#profile").val();
    $("#panelType").removeClass("panel-success panel-warning panel-danger").addClass("panel-info");
    $("#contentHeader").html(user + "'s Profile");
  });
}

function profile(){
  $("#notify").addClass("hidden").removeClass("error good");
  $("#home").addClass("clear");
  $("#tasks").addClass("clear");
  $("#videos").addClass("clear");
  $("#notes").addClass("clear");
  loadProfile();
}

function showPhotos(){
  $("#notify").addClass("hidden").removeClass("error good");
  $.post('Profile/profileHandler.php', {
    action: 'photos'
  },
  function(data){
    $("#content").html(data);
  });
}

function changePhoto(file, alt){
  $.post('Profile/profileHandler.php', {
    action: 'updatephoto',
    src: file,
    alt: alt
  },
  function(data){
    $("#content").html(data);
  });
}

function usernameInput(){
  $("#notify").addClass("hidden").removeClass("error good");
  $("#userToUpdate").prop("disabled", false);
  $("#userUpdateBtn").addClass("hidden");
  $("#userUpdateConf").removeClass("hidden");
  $("#userUpdateCanc").removeClass("hidden");
}

function confirmUserUpdate(user){
  var newUser = $("#userToUpdate").val();
  $.post('Profile/profileHandler.php', {
    action: 'userupdate',
    newUser: newUser
  },
  function(data){
    if(data == 1){
      $("#profile").val(newUser);
      $(".dropdown-toggle").html(newUser + " <span class='caret'></span>");
      loadProfile();
      $("#notify").html("<strong>SUCCESS: </strong>Username Updated");
      $("#notify").addClass("good");
    }else{
      $("#notify").html(data);
      $("#notify").addClass("error");
    }
  });
  $("#notify").removeClass("hidden");
}

function confirmEmailUpdate(email){
  var newEmail = $("#emailToUpdate").val();
  $.post('Profile/profileHandler.php', {
    action: 'emailupdate',
    newEmail: newEmail,
    oldEmail: email
  },
  function(data){
    if(data == 1){
      loadProfile();
      $("#notify").html("<strong>SUCCESS: </strong>Email Updated");
      $("#notify").addClass("good");
    }else{
      $("#notify").html(data);
      $("#notify").addClass("error");
    }
  });
  $("#notify").removeClass("hidden");
}

function cancelUserUpdate(user){
  $("#notify").addClass("hidden").removeClass("error good");
  $("#userToUpdate").val($("#profile").val());
  $("#userToUpdate").prop("disabled", true);
  $("#userUpdateBtn").removeClass("hidden");
  $("#userUpdateConf").addClass("hidden");
  $("#userUpdateCanc").addClass("hidden");
}

function emailInput(){
  $("#notify").addClass("hidden").removeClass("error good");
  $("#emailToUpdate").prop("disabled", false);
  $("#emailUpdateBtn").addClass("hidden");
  $("#emailUpdateConf").removeClass("hidden");
  $("#emailUpdateCanc").removeClass("hidden");
}

function cancelEmailUpdate(email){
  $("#notify").addClass("hidden").removeClass("error good");
  $("#emailToUpdate").val(email);
  $("#emailToUpdate").prop("disabled", true);
  $("#emailUpdateBtn").removeClass("hidden");
  $("#emailUpdateConf").addClass("hidden");
  $("#emailUpdateCanc").addClass("hidden");
}

function passwordInput(){
  $("#passUpdateBtn").addClass("hidden");
  $("#psswdForm").removeClass("hidden");
}

function cancelPassUpdate(){
  $("#ogPass").val("");
  $("#ogPassConf").val("");
  $("#newPass").val("");
  $("#psswdForm").addClass("hidden");
  $("#passUpdateBtn").removeClass("hidden");
}

function confirmPassUpdate(){
  var ogPass = $("#ogPass").val();
  var ogPassConf = $("#ogPassConf").val();
  var newPass = $("#newPass").val();
  $.post('Profile/profileHandler.php', {
    action: 'passcheck',
    pass: ogPass,
    newPass: newPass,
    passConf: ogPassConf
  },
  function(data){
    if(data == 1){
      cancelPassUpdate();
      $("#notify").html("<strong>SUCCESS: </strong>Password Successfully Updated");
      $("#notify").addClass("good");
    }else{
      $("#notify").html(data);
      $("#notify").addClass("error");
    }
  });
  $("#notify").removeClass("hidden");
}
