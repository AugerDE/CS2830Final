$(function(){

  $("#tasks").click(function(){
    console.log("clicked");
    var usrnm = $("#profile").val();
    $.post('tabs.php', {
      action: 'tasks',
      usrnm: usrnm
    },
    function(data){
      $("#taskPanel").html(data);
    });
  });

});
