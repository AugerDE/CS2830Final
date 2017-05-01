$(function(){

  $("#login").click(function(){
    var usrnm = $("#usrnm").val();
    var psswd = $("#psswd").val();
    if(usrnm == "" || psswd == ""){
      $("#errorMessage").html("<strong>ERROR: </strong>All Fields Required");
      $("#errorMessage").removeClass("hidden");
    }else{

    }
  });

});
