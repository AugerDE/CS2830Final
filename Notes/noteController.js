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
  // $.post('Notes/noteHandler.php', {
  //   action: 'add'
  // },
  // function(data){
  //   saveNotes();
  //   loadNotes();
  // });
  var i = 1;
  $(".noteContainer").children().each(index){
    i += index;
  }
  note = newNote(i);
  $(".noteContainer").append(note);
}

function newNote(num){
  var note = "<div class='notes'>";
      note += "<button class='btn btn-sm btn-danger closeNote' onclick='deleteNote('" + num + "')'>";
      note += "<span class='glyphicon glyphicon-remove'></span>";
      note += "</button>";
      note += "<textarea spellcheck='false'>New Note '" + num + "'></textarea>";
      note += "</div>";
  return note;
}

function deleteNote(id){
  $.post('Notes/noteHandler.php', {
    action: 'delete',
    id: id
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
    div = $(".notes").eq(index);
    oldT = text.html();
    newT = text.val();
    x = div.offset().left;
    y = div.offset().top;
    offx = div.parent().offset().left;
    offy = div.parent().offset().top;
    divx = x - offx;
    divy = y - offy;
    fix = 200 * index;
    divy -= fix;
    $.post('Notes/noteHandler.php', {
      action: 'save',
      oldText: oldT,
      newText: newT,
      x: divx,
      y: divy
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
