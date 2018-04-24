$(function(){
	//删除按钮
	$("body").on("click","#btnsubmit",function(){
		if(!$(this).hasClass("btn-unactive")){
		layer.confirm('确认进行批量删除吗？', 
			function(index, layero){

			   $(".ajaxForm").submit();
			}, function(index){

			});
		}
	

		return false;
	})

	//删除按钮特效
	// $("body").on("change","[name='n_id[]']",function(){
	// 	$.each($("[name='n_id[]']"),function(i,v){
	// 		if($(v).is(':checked')){
	// 			$("#btnsubmit").addClass("active")
	// 			return false;
	// 		}else{
	// 			$("#btnsubmit").removeClass("active")
	// 		}
	// 	})
		
	// })
	// $("#chkAll").change(function(){
	// 	if($(this).is(':checked')){
	// 		$("#btnsubmit").addClass("active")
	// 		return false;
	// 	}else{
	// 		$("#btnsubmit").removeClass("active")
	// 	}
	// })

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