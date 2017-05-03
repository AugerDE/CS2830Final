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
  $.post('Notes/noteController.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data);
  });
}
