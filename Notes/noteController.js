$(function(){
  $("#notes").click(function(){
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").addClass("clear");
    $("#notes").removeClass("clear");
    $("#content").addClass("noteContainer");
    loadNotes();
  });
});

function loadNotes(){
  $.post('Notes/noteHandler.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data);
    $("#notify").html("<button class='btn btn-success' onclick='addNote()'>Add a Note</button>").removeClass("hidden");
    $(".notes").draggable({
      containment: "#content"
    });
  });
}

function addNote(){
  $.post('Notes/noteHandler.php', {
    action: 'add'
  },
  function(data){
    if(data == 1){
      loadNotes();
    }
  });
}
