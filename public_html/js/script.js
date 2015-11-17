$(document).ready(function(){

	$(".delete_comment").click(function(){
    if (!confirm("Do you want to delete this comment ?")){
      return false;
    }
  });

  $(".delete_photo").click(function(){
    if (!confirm("Do you want to delete this photo ?")){
      return false;
    }
  });

  $(".delete_log_file").click(function(){
    if (!confirm("Do you want to clear the log file ?")){
      return false;
    }
  });

  $(".photo").hover(function(){
      $(this).css("border-radius", "20px");
      }, function(){
      $(this).css("border-radius", "10px");
  });

});