$(function(){
  $("#videos").click(function(){
    $("#notify").hide();
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").removeClass("clear");
    $("#notes").addClass("clear");
    loadVideos();
  });
});

function loadVideos(){
  $.post('Videos/videoHandler.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data);
    var user = $("#profile").val();
    $("#panelType").removeClass("panel-success panel-warning panel-info").addClass("panel-danger");
    $("#contentHeader").html(user + "'s Videos");
  });
}
