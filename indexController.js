$(function(){

  $("#login").click(function(){
    var usrnm = $("#usrnm").val();
    var psswd = $("#psswd").val();
    if(usrnm == "" || psswd == ""){
      $("#errorMessage").html("<strong>ERROR: </strong>All Fields Required");
      $("#errorMessage").removeClass("hidden");
    }else{
      $.post('indexHandler.php', {
        action: 'login',
        usrnm: usrnm,
        psswd: psswd
      },
      function(data){
        if(data == 1){
          $("#errorMessage").html("<strong>SUCCESS: </strong>Logged In");
          $("#errorMessage").removeClass("hidden error").addClass("good");
        }else{
          $("#errorMessage").html(data);
          $("#errorMessage").removeClass("hidden");
        }
      });
    }
  });

});
