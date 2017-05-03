$(function(){
  load();
});

function load(){
  $.post('Index/indexHandler.php', {
    action: 'content'
  },
  function(data){
    $("#content").html(data);
  });
}

function login(){
  var usrnm = $("#usrnm").val();
  var psswd = $("#psswd").val();
  $.post('Index/indexHandler.php', {
    action: 'login',
    usrnm: usrnm,
    psswd: psswd
  },
  function(data){
    if(data == 1){
      window.location.href = "home.php";
    }else{
      $("#loginMessage").html(data);
      $("#loginMessage").addClass("error").removeClass("hidden");
    }
  });
}

function register(){
  var email = $("#email").val();
  var usrnm = $("#newUser").val();
  var psswd = $("#newPsswd").val();
  var pconf = $("#psswdConf").val();
  $.post('Index/indexHandler.php', {
    action: 'register',
    email: email,
    usrnm: usrnm,
    psswd: psswd,
    pconf: pconf
  },
  function(data){
    if(data == 1){
      $("#registerMessage").html("<strong>USER CREATED: </strong>Now Just Log-in!");
      $("#registerMessage").addClass("good");
    }else{
      $("#registerMessage").html(data);
      $("#registerMessage").addClass("error");
    }
  });
  $("#registerMessage").removeClass("hidden");
}
