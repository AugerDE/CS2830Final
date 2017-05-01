$(function(){

  loadTab("home");

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
    $("#home").addClass("clear");
    $("#tasks").removeClass("clear");
    $("#videos").addClass("clear");
    $("#notes").addClass("clear");
    loadTasks();
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
    }
  });
}

function loadTasks(){
  var user = $("#profile").val();
  $("#notify").addClass("hidden");
  $.post('tabs.php', {
    action: 'tasks'
  },
  function(data){
    $("#panelType").removeClass("panel-success panel-info panel-danger").addClass("panel-warning");
    $("#contentHeader").html(user + "'s Tasks");
    $("#content").html(data);
  });
}

function editTask(name, desc, date, time, stat){
  $("#notify").addClass("hidden");
  $("#addTaskBtn").addClass("hidden");
  $("#task").val(name);
  $("#name").val(name);
  $("#desc").val(desc);
  $("#date").val(date);
  $("#time").val(time);
  $("#stat").val(stat);
  $("#editTaskForm").removeClass("hidden");
}

function deleteTask(name, desc, date, time, stat){
  $("#notify").addClass("hidden");
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
  loadTasks();
}

function updateTask(){
  $("#notify").addClass("hidden");
  var task = $("#task").val();
  var name = $("#name").val();
  var desc = $("#desc").val();
  var date = $("#date").val();
  var time = $("#time").val();
  var stat = $("#stat").val();
  if(name == "" || desc == "" || date == "" || time == "" || stat == ""){
    $("#notify").html("<strong>ERROR: </strong>All Inputs Required");
    $("#notify").addClass("error").removeClass("hidden");
  }else{
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
      $("#content").html(data);
      $("#notify").html("<strong>SUCCESS: </strong>Your Task Has Been Updated");
      $("#notify").addClass("good").removeClass("hidden");
    });
  }
}

function addForm(){
  $("#notify").addClass("hidden");
  $("#addTaskBtn").addClass("hidden");
  $("#addTaskForm").removeClass("hidden");
}

function addTask(){
  $("#notify").addClass("hidden");
  var name = $("#tskname").val();
  var desc = $("#tskdesc").val();
  var date = $("#tskdate").val();
  var time = $("#tsktime").val();
  var stat = $("#tskstat").val();
  if(name == "" || desc == "" || date == "" || time == "" || stat == ""){
    $("#notify").html("<strong>ERROR: </strong>All Inputs Required");
    $("#notify").addClass("error").removeClass("hidden");
  }else{
    $.post('tabs.php', {
      action: 'add',
      name: name,
      desc: desc,
      date: date,
      time: time,
      stat: stat
    },
    function(data){
      $("#content").html(data);
      $("#notify").html("<strong>SUCCESS: </strong>Your Task Has Been Added");
      $("#notify").addClass("good").removeClass("hidden");
    });
  }
}
