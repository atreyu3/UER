$(document.body).on("click",".opcion",function(){
	var form=$(this).data('target');
	$.ajax({
		url:$(this).attr("href"),
		success:function(dat){
		$(form+"-form").html(dat);
		}
	});
});

$(document.body).on('change','select.pagination', function() {
    document.location.href = $(this).attr('data-change') + '?records=' + $(this).val();
});