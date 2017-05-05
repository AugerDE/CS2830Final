$(function(){
  loadHome();
  $("#home").click(function(){
    $("#notify").hide();
    $("#home").removeClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").addClass("clear");
    $("#notes").addClass("clear");
    loadHome();
  });
});

function loadHome(){
  $.post('homeHandler.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data);
  });
}
