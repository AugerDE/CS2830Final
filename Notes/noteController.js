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
  $("#content textarea").each(function(cont){
    text[i] = $("textarea")[i].html();
    console.log(text[i].innerHTML);
    divs[i] = $(".notes")[i];
    i++;
  });

  y = 0;
  for(i = 0; i < text.length; i++){
    cont = text[i].innerHTML;
    x = divs[i].offsetLeft - 31;
    y = divs[i].offsetTop - 100;
    // $.post('Notes/noteHandler.php', {
    //   action: "save",
    //   cont: cont,
    //   x: x,
    //   y: y,
    //   i: i
    // },
    // function(data){
    //   if(data != 1){
    //     $("#notify").html(data).removeClass("hidden");
    //   }
    // });
  }
  // loadNotes();
}
