/*******************************************************
** jQuery notification center functions
** how to use : $('#element').pushLink();
**              $('#element').friendLink(buttonElement: '.button', ncfriendloadingElement: '#ncfriendloading', ncfriendresultmessageElement: '#ncfriendresultmessage');
**              $('#element').friendUnlink(buttonElement: '.button', ncfriendloadingElement: '#ncfriendloading', ncfriendresultmessageElement: '#ncfriendresultmessage');
** @author    : Shouta Kashiwagi <kashiwagi@tejimaya.com>
*********************************************************/

(function($){
	var _followScroll = true;
	var _readyBound = false;

	$.fn.pushLink = function(settings){
		return this.each(function(){
			var linkUrl = $(this).attr('data-location-url');
			var notifyId = $(this).attr('data-notify-id');
			var notifyUrl = $(this).attr('data-notify-url');
			$(this).mouseover(function(){
				$(this).addClass('hover');
			})
			.mouseout(function(){
				$(this).removeClass('hover');
			})
			$(this).click(function(){
				$.getJSON( notifyUrl , { 'id': notifyId, 'apiKey': openpne.apiKey }, function(d){});
				window.location = linkUrl;
			});
		});
	};

	$.fn.friendLink = function(settings){
		return this.each(function(){
			$(this).click(function(){
				$(settings.buttonElement).hide();
				$(settings.ncfriendloadingElement).show();
				var sendUrl = $(this).attr('data-post-url');
				var memberId = $(this).attr('data-member-id');
				var notifyId = $(this).attr('data-notify-id');
				var notifyUrl = $(this).attr('data-notify-url');
				$.getJSON( notifyUrl , { 'id': notifyId, 'apiKey': openpne.apiKey }, function(d){});
				$.ajax({
					url: sendUrl,
					type: 'GET',
					data: 'member_id=' + memberId + '&apiKey=' + openpne.apiKey,
					dataType: 'json',
					success: function(data) {
						if(data.status=='success'){
							$(settings.ncfriendloadingElement).hide();
							$(settings.ncfriendresultmessageElement).text('フレンド申請を承認しました。');
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
				$(settings.buttonElement).hide();
				$(settings.ncfriendloadingElement).show();
				var sendUrl = $(this).attr('data-post-url');
				var memberId = $(this).attr('data-member-id');
				var notifyId = $(this).attr('data-notify-id');
				var notifyUrl = $(this).attr('data-notify-url');
				$.getJSON( notifyUrl , { 'id': notifyId, 'apiKey': openpne.apiKey }, function(d){});
				$.ajax({
					url: sendUrl,
					type: 'GET',
					data: 'member_id=' + memberId + '&apiKey=' + openpne.apiKey,
					dataType: 'json',
					success: function(data) {
						if(data.status=='success'){
							$(settings.ncfriendloadingElement).hide();
							$(settings.ncfriendresultmessageElement).show();
							$(settings.ncfriendresultmessageElement).text('フレンド申請を拒否しました。');
						}else{
							alert(data.message);
						}   
					}
				});
			});
		});
        };

})(jQuery);
