$(function(){
  $("#notes").click(function(){
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").addClass("clear");
    $("#notes").removeClass("clear");
    $("#content").addClass("noteContainer");
    $("#notify").html("<button class='btn btn-success' onclick='addNote()'>Add a Note</button>").removeClass("hidden");
    loadNotes();
  });
});

function loadNotes(){
  $.post('Notes/noteHandler.php', {
    action: 'load'
  },
  function(data){
    $("#content").html(data);
    $("#notify").html("<button class='btn btn-success' onclick='addNote()'>Add a Note</button> <button class='btn btn-info' onclick='saveNotes()'>Save Notes</button>").removeClass("hidden");
    $(".notes").draggable({
      containment: "#content"
    });
  });
}

function addNote(){
  console.log("click");
  $.post('Notes/noteHandler.php', {
    action: 'add'
  },
  function(data){
    if(data == 1){
      loadNotes();
    }else{
      $("#notify").html(data).removeClass("hidden");
    }
  });
}

function deleteNote(y, x, cont){
  $.post('Notes/noteHandler.php', {
    action: 'delete',
    x: x,
    y: y,
    cont: cont
  },
  function(data){
    if(data == 1){
      loadNotes();
    }else{
      $("#notify").html(data).removeClass("hidden");
    }
  });
}

function saveNotes(){
  text = [];
  divs = [];
  var i = 0;
  $("#content textarea").each(function(){
    text = $("textarea");
    newText = text.eq(i).val();
    oldText = text.eq(i).html();
    console.log("New: " + newText);
    console.log("Old: " + oldText);
    i++;
  });
  i = 0;
  $("#content .notes").each(function(){
    position = $(".notes");
    console.log("Top: " + position.eq(i).offset().top);
    console.log("Left: " + position.eq(i).offset().left);
    i++;
  });


}
