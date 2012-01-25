/*******************************************************
** jQuery notification center functions
** how to use : $('#element').pushLink();
**              $('#element').friendLink();
**              $('#element').friendUnlink();
** @author    : Shouta Kashiwagi <kashiwagi@tejimaya.com>
*********************************************************/

(function($){
	var _followScroll = true;
	var _readyBound = false;

	$.fn.pushLink = function(settings){
		return this.each(function(){
			linkUrl = $(this).attr('data-location-url');
			$(this).mouseover(function(){
				$(this).addClass('hover');
			})
			.mouseout(function(){
				$(this).removeClass('hover');
			})
			$(this).click(function(){
				window.location = linkUrl;
			});
		});
	};

	$.fn.friendLink = function(settings){
		return this.each(function(){
			$(this).click(function(){
				var sendUrl = $(this).attr('data-post-url');
				var memberId = $(this).attr('data-member-id');
				$.ajax({
					url: sendUrl,
					type: 'POST',
					data: 'member_id=' + memberId,
					dataType: 'json',
					success: function(data) {
						if(data.status=='success'){
							// FIXME $(this).
						}else{
							alert(data.message);
						}   
					}
				});
			});
		});
        };


	$.fn.friendUnlink = function(settings){
		return this.each(function(){
			$(this).click(function(){
				var sendUrl = $(this).attr('data-post-url');
				var memberId = $(this).attr('data-member-id');
				$.ajax({
					url: sendUrl,
					type: 'POST',
					data: 'member_id=' + memberId,
					dataType: 'json',
					success: function(data) {
						if(data.status=='success'){
							// FIXME $(this).
						}else{
							alert(data.message);
						}   
					}
				});
			});
		});
        };

})(jQuery);
