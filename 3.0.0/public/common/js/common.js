$(function(){
	//删除按钮
	$("body").on("click","#btnsubmit",function(){
		if(!$(this).hasClass("btn-unactive")){
		layer.confirm('确认进行批量删除吗？',{icon: 3},  
			function(index, layero){

			   $(".ajaxForm").submit();
			}, function(index){

			});
		}
	

		return false;
	})
	// $("body").on("click",".fb-page li",function(){
	// 	$(this).addClass("active").siblings("li").removeClass("active");

	// })
	//批量审核特效
	$("body").on("change","[name='n_id[]']",function(){
		$.each($("[name='n_id[]']"),function(i,v){
			if($(v).is(':checked')){
				$("#member_active_submit").addClass("active")
				return false;
			}else{
				$("#member_active_submit").removeClass("active")
			}
		})
		
	})
	$("#chkAll").change(function(){
		if($(this).is(':checked')){
			$("#member_active_submit").addClass("active")
			return false;
		}else{
			$("#member_active_submit").removeClass("active")
		}
	})

	// try{
	// 	var mTop = $(".maintop").offset().top;
	// 	var mH = $(".maintop").outerHeight();
	// 	$(window).on("scroll",function(){
	// 		var t = $(window).scrollTop();
	// 		if(t>=mTop-mH){
	// 			// $(".maintop").addClass("active");
	// 			$(".page-content").css("padding-top",mH+' !important')
	// 		}else{
	// 			$(".maintop").removeClass("active")
	// 			$(".page-content").css("padding-top",0)


	// 		}
	// 	})
		
	// }catch(e){

	// }
})