$(function(){

  $("#login").click(function(){
    var usrnm = $("#usrnm").val();
    var psswd = $("#psswd").val();
    if(usrnm == "" || psswd == ""){
      $("#loginMessage").html("<strong>ERROR: </strong>All Fields Required");
      $("#loginMessage").removeClass("hidden");
    }else{
      $.post('indexHandler.php', {
        action: 'login',
        usrnm: usrnm,
        psswd: psswd
      },
      function(data){
        if(data == 1){
          $("#loginMessage").addClass("hidden");
          window.location.href = "home.php";
        }else{
          $("#loginMessage").html(data);
          $("#loginMessage").removeClass("hidden");
        }
      });
    }
  });

  $("#register").click(function(){
    var email = $("#email").val();
    var usrnm = $("#newUsrnm").val();
    var psswd = $("#newPsswd").val();
    var pconf = $("#psswdConf").val();
    if(email == "" || usrnm == "" || psswd == "" || pconf == ""){
      $("#registerMessage").html("<strong>ERROR: </strong>All Fields Required");
      $("#registerMessage").addClass("error");
    }else if(psswd != pconf){
      $("#registerMessage").html("<strong>ERROR: </strong>Passwords Do Not Match");
      $("#registerMessage").addClass("error");
    }else{

    }
    $("#registerMessage").removeClass("hidden");
  });

});
