$(function(){

  $.post('tabs.php', {
    action: 'home'
  },
  function(data){
    $("#content").html(data);
  });

  $("#tasks").click(function(){
    var usrnm = $("#profile").val();
    console.log("clicked: " + usrnm);
    $.post('tabs.php', {
      action: 'tasks',
      usrnm: usrnm
    },
    function(data){
      console.log("Data: " + data);
      $("#content").html(data);
    });
  });

});
