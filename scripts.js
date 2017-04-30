$(function(){

  $("#home").click(function(){
    loadTab("home");
  });

  $("#tasks").click(function(){
    $.post('tabs.php', {
      action: 'tasks'
    },
    function(data){
      $("#content").html(data);
    });
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
