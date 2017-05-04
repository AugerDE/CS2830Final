$(function(){
  $("#notes").click(function(){
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").addClass("clear");
    $("#notes").removeClass("clear");
    loadNotes();
  });
});

function loadNotes(){
  $.post('Notes/noteHandler.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data).addClass("noteContainer");
    $("#notify").html("<button class='btn btn-success'>Add a Note</button>").removeClass("hidden");
    $(".notes").draggable({
      containment: "#content"
    });
  });
}
