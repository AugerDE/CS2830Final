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
    $("#content").html("<div class='noteContainer'></div>");
    $(".noteContainer").html(data);
    var user = $("#profile").val();
    $("#panelType").removeClass("panel-info panel-warning panel-danger").addClass("panel-success");
    var btn = getButtons();
    $("#contentHeader").html(user + "'s Notes" + btn);
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
    pos = $(".notes");
    x = pos.eq(i).position().left - 31;
    y = pos.eq(i).position().top - 100;
    $.post('Notes/noteHandler.php', {
      action: 'save',
      oldText: oldText,
      newText: newText,
      x: x,
      y: y
    },
    function(data){
      if(data != 1){
        $("#notify").html(data).removeClass("hidden");
      }
    });
    i++;
  });
}

function getButtons(){
  var button = "<div id='noteBtns'><button class='btn btn-success' onclick='addNote()'>Add a Note</button> <button class='btn btn-info' onclick='saveNotes()'>Save Notes</button></div>";
  return button;
}
