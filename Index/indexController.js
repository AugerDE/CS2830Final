$(function(){

  $.post('Index/indexHandler.php', {
    action: 'content'
  },
  function(data){
    $("#content").html(data);
  });

});

function login(){
  var usrnm = $("#usrnm").val();
  var psswd = $("#psswd").val();
  if(usrnm == "" || psswd == ""){
    $("#loginMessage").html("<strong>ERROR: </strong>All Inputs Required");
    $("#loginMessage").addClass("error");
    $("#loginMessage").removeClass("hidden");
  }else{
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
        $("#loginMessage").addClass("error");
        $("#loginMessage").removeClass("hidden");
      }
    });
  }
}

function register(){
  var email = $("#email").val();
  var usrnm = $("#newUser").val();
  var psswd = $("#newPsswd").val();
  var pconf = $("#psswdConf").val();
  console.log(email);
  console.log(usrnm);
  console.log(psswd);
  console.log(pconf);
}
