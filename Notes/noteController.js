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

function deleteNote(cont){
  $.post('Notes/noteHandler.php', {
    action: 'delete',
    content: cont
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
  $(".noteContainer").children().each(function(index, value){
    text = $("textarea").eq(index);
    cont = $(".noteContainer").position();
    div = $(".notes").eq(index).offset();
    oldT = text.html();
    newT = text.val();
    x = div.left - 31;
    y = cont.top - 136;
    $.post('Notes/noteHandler.php', {
      action: 'save',
      oldText: oldT,
      newText: newT,
      x: x,
      y: y
    },
    function(data){
      if(data != 1){
        $("#notify").html(data).removeClass("hidden");
      }
    });
  });
}

function getButtons(){
  var button = "<div id='noteBtns'><button class='btn btn-success' onclick='addNote()'>Add a Note</button> <button class='btn btn-info' onclick='saveNotes()'>Save Notes</button></div>";
  return button;
}
