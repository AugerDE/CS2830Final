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
  $.get('Videos/videoHandler.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data);
  });
}

function changeVideo(thumb, vid){
  console.log(thumb);
  console.log(vid);
  $("#vidPlayer").attr('src', vid);
  $("#vidPlayer").removeClass("hidden");
}
