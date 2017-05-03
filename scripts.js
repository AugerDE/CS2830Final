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
