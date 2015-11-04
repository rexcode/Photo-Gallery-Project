$(document).ready(function(){

	$(".delete_comment").click(function(){
    if (!confirm("Do you want to delete ?")){
      return false;
    }
  });

  $(".delete_photo").click(function(){
    if (!confirm("Do you want to delete ?")){
      return false;
    }
  });


  $(".photo").hover(function(){
      $(this).css("border-radius", "20px");
      }, function(){
      $(this).css("border-radius", "10px");
  });

});