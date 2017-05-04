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
    pos = $(".notes");
    x = pos.eq(i).position().left - 31;
    y = pos.eq(i).position().top - 100;
    console.log("Top: " + y);
    console.log("Left: " + x);
    i++;
  });


}
