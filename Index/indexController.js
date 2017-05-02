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
  console.log(usrnm);
  console.log(psswd);
}
