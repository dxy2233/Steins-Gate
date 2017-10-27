$(function(){
    $(".navbox a span").click(function(){
    	$(this).addClass("actiovanav").parent().siblings().children("span").removeClass("actiovanav");
    });
    $(".right_btn2").click(function(){
    	$(".input_name").val("");
    });
    $(".yonghuname2").click(function(){
    	$(this).children(".right_btn5").addClass("age").parent().siblings().children(".right_btn5").removeClass("age");
    });
     
    
})