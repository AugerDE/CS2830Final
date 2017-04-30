$(function(){

  loadTab("home");

  $("#home").click(function(){
    loadTab("home");
  });

  $("#tasks").click(function(){
    loadTab("tasks");
  });

});

function loadTab(tab){
  var user = $("#profile").val();
  switch(tab){
    case "home":
      $("#contentHeader").html("Welcome back, " + user + "!");
      break;
    case "notes":
      $("#contentHeader").html(user + "'s Notes");
      break;
    case "tasks":
      $("#contentHeader").html(user + "'s Tasks");
      break;
  }
  $.post('tabs.php', {
    action: tab
  },
  function(data){
    $("#content").html(data);
  });
}

function editTask(name, desc, date, time, stat){
  console.log(name + " " + desc + " " + date + " " + time + " " + stat);
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
  console.log(name + " " + desc + " " + date + " " + time + " " + stat);
}

function cancel(){
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
    $("#content").html(data);
  });
}
