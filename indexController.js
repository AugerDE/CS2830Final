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
    console.log(email);
    console.log(usrnm);
    console.log(psswd);
    console.log(pconf);
  });

});
