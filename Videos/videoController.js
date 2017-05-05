$(function(){
  $("#videos").click(function(){
    $("#notify").hide();
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").removeClass("clear");
    $("#notes").addClass("clear");
    loadVideos("load");
  });
});

function loadVideos(action){
  $.get('Videos/videoHandler.php', {
    action: action
  },
  function(data){
    $("#content").html(data);
  });
}

function getFunny(){
  loadVideos("funny");
}

function getGaming(){
  loadVideos("gaming");
}

function getTech(){
  loadVideos("tech");
}

function changeVideo(thumb, vid){
  console.log(thumb);
  console.log(vid);
  $("#vidBtnHolder").addClass("hidden");
  $("#vidPlayer").attr('src', vid);
  $("#vidPlayer").removeClass("hidden");
  $("#changeVid").removeClass("hidden");
  $("#changeGenre").addClass("hidden");
}

function hideVideo(genre){
  loadVideos(genre);
}

function switchGenre(){
  loadVideos("load");
}
