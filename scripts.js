$(function(){

  $("#tasks").click(function(){
    var usrnm = $("#profile").val();
    $.post('tabs.php', {
      action: 'tasks',
      usrnm: usrnm
    },
    function(data){
      $("#mainBody").html(data);
    });
  });

});
