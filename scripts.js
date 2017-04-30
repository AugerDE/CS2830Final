$(function(){

  $("#tasks").click(function(){
    var usrnm = $("#profile").val();
    $.post('tabs.php', {
      action: 'tasks',
      usrnm: usrnm
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
