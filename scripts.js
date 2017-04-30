$(function(){

  $("#home").click(function(){
    loadTab("home");
  });

  $("#tasks").click(function(){
    loadTab("tasks");
  });

});

function loadTab(tab){
  $.post('tabs.php', {
    action: tab
  },
  function(data){
    $("#content").html(data);
  });
}
