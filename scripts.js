$(function(){

  $("#content").html("<img src='shakeIt.gif' alt='shake' height='100' width='100'>");
  // loadTab("home");

  $("#home").click(function(){
    $("#notify").hide();
    $("#home").removeClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").addClass("clear");
    $("#notes").addClass("clear");
    loadTab("home");
  });

  $("#notes").click(function(){
    $("#notify").hide();
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").addClass("clear");
    $("#notes").removeClass("clear");
  });

  $("#tasks").click(function(){
    $("#notify").hide();
    $("#home").addClass("clear");
    $("#tasks").removeClass("clear");
    $("#videos").addClass("clear");
    $("#notes").addClass("clear");
    loadTab("tasks");
  });

  $("#videos").click(function(){
    $("#notify").hide();
    $("#home").addClass("clear");
    $("#tasks").addClass("clear");
    $("#videos").removeClass("clear");
    $("#notes").addClass("clear");
  });

});

function loadTab(tab){
  $.post('tabs.php', {
    action: tab
  },
  function(data){
    $("#content").html(data);
    var user = $("#profile").val();
    switch(tab){
      case "home":
        $("#panelType").removeClass("panel-success panel-warning panel-danger").addClass("panel-info");
        $("#contentHeader").html("Welcome back, " + user + "!");
        break;
      case "notes":
        $("#panelType").removeClass("panel-info panel-warning panel-danger").addClass("panel-success");
        $("#contentHeader").html(user + "'s Notes");
        break;
      case "tasks":
        $("#panelType").removeClass("panel-success panel-info panel-danger").addClass("panel-warning");
        $("#contentHeader").html(user + "'s Tasks");
        break;
      case "videos":
        $("#panelType").removeClass("panel-success panel-warning panel-info").addClass("panel-danger");
        $("#contentHeader").html(user + "'s Videos");
        break;
      case "profile":
        $("#panelType").removeClass("panel-success panel-warning panel-danger").addClass("panel-info");
        $("#contentHeader").html(user + "'s Profile");
        break;
    }
  });
}

function editTask(name, desc, date, time, stat){
  $("#notify").hide();
  $.post('tabs.php', {
    action: 'edit',
    name: name,
    desc: desc,
    date: date,
    time: time,
    stat: stat
  },
  function(data){
    $("#content").html(data);
  });
}

function deleteTask(name, desc, date, time, stat){
  $("#notify").hide();
  $.post('tabs.php', {
    action: 'delete',
    name: name,
    desc: desc,
    date: date,
    time: time,
    stat: stat
  },
  function(data){
    $("#content").html(data);
  });
}

function removeTask(){
  $("#notify").hide();
  var task = $("#task").val();
  $.post('tabs.php', {
    action: 'remove',
    task: task
  },
  function(data){
    $("#content").html(data);
    $.post('tabs.php', {
      action: 'deletesuccess'
    },
    function(data){
      $("#notify").show();
      $("#notify").html(data);
    });
  });
}

function cancel(){
  $("#notify").hide();
  loadTab("tasks");
}

function updateTask(){
  var task = $("#task").val();
  var name = $("#tskname").val();
  var desc = $("#tskdesc").val();
  var date = $("#tskdate").val();
  var time = $("#tsktime").val();
  var stat = $("#tskstat").val();
  $.post('tabs.php', {
    action: 'update',
    task: task,
    name: name,
    desc: desc,
    date: date,
    time: time,
    stat: stat
  },
  function(data){
    if(data == "empty"){
      $.post('tabs.php', {
        action: "empty"
      },
      function(data){
        $("#notify").show();
        $("#notify").html(data);
      });
    }else{
      $("#content").html(data);
      $.post('tabs.php', {
        action: 'updatesuccess'
      },
      function(data){
        $("#notify").show();
        $("#notify").html(data);
      });
    }
  });
}

function addForm(){
  $("#notify").hide();
  $.post('tabs.php', {
    action: 'showadd'
  },
  function(data){
    $("#content").html(data);
  });
}

function addTask(){
  var name = $("#tskname").val();
  var desc = $("#tskdesc").val();
  var date = $("#tskdate").val();
  var time = $("#tsktime").val();
  var stat = $("#tskstat").val();
  $.post('tabs.php', {
    action: 'add',
    name: name,
    desc: desc,
    date: date,
    time: time,
    stat: stat
  },
  function(data){
    if(data == "empty"){
      $.post('tabs.php', {
        action: "empty"
      },
      function(data){
        $("#notify").show();
        $("#notify").html(data);
      });
    }else{
      $("#content").html(data);
      $.post('tabs.php', {
        action: 'addsuccess'
      },
      function(data){
        $("#notify").show();
        $("#notify").html(data);
      });
    }
  });
}

function profile(){
  console.log("clicked");
  $("#notify").hide();
  $("#home").addClass("clear");
  $("#tasks").addClass("clear");
  $("#videos").addClass("clear");
  $("#notes").addClass("clear");
  loadTab("profile");
}
