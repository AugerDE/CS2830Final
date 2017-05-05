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
    var user = $("#profile").val();
    $("#panelType").removeClass("panel-success panel-warning panel-danger").addClass("panel-info");
    $("#contentHeader").html( user + "'s Home Page");
    $("#content").html(data);
  });
}
