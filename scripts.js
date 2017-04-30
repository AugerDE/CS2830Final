$(function(){

  $.post('tabs.php', {
    action: 'home'
  },
  function(data){
    $("#content").html(data);
  });

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
