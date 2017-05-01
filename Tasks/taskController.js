$(function(){
  $("#tasks").click(function(){
    $("#home").addClass("clear");
    $("#tasks").removeClass("clear");
    $("#videos").addClass("clear");
    $("#notes").addClass("clear");
    loadTasks();
  });
});

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
  $("#addTaskBtn").addClass("hidden");
  $("#deltask").val(name);
  $("#delname").val(name);
  $("#deldesc").val(desc);
  $("#deldate").val(date);
  $("#deltime").val(time);
  $("#delstat").val(stat);
  $("#deleteTaskForm").removeClass("hidden");
}

function removeTask(){
  var task = $("#deltask").val();
  $.post('tabs.php', {
    action: 'remove',
    task: task
  },
  function(data){
    $("#content").html(data);
    $("#notify").html("<strong>SUCCESS: </strong>Your Task Has Been Deleted");
    $("#notify").addClass("good").removeClass("hidden");
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
