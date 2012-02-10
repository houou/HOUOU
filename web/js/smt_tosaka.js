$(document).ready(function(){
  $(".commentbutton").click(function(){
    $(".commentform").toggle();
    $(".commentbutton").toggle();
  });

  $(".postbutton").click(function(){
    $(".toggle1:not(.postform)").hide();
    $(".postform").toggle();
    if($(".postform").is(":visible")){
      $(".posttextarea").focus();
    }
  });

  $(".ncbutton").click(function(){
    $(".toggle1:not(.ncform)").hide();
    $(".ncform").toggle();
    $('#pushLoading').show();
    $.getJSON( openpne.apiBase + 'push/search.json?apiKey=' + openpne.apiKey, function(json){
      if(json.status=='success')
      {
        $pushHtml = $("#pushListTemplate").tmpl(json.data);
        $('.divlink', $pushHtml).pushLink();
	$('.friend-accept', $pushHtml).friendLink({ buttonElement: '.friend-notify-button', ncfriendloadingElement: '#ncfriendloading', ncfriendresultmessageElement: '#ncfriendresultmessage', });
	$('.friend-reject', $pushHtml).friendUnlink({ buttonElement: '.friend-notify-button', ncfriendloadingElement: '#ncfriendloading', ncfriendresultmessageElement: '#ncfriendresultmessage', })
        $("#pushList").html($pushHtml);
      }else{
        alert(json.message);
      }
      $('#pushList').show();
      $('#pushLoading').hide();
    });
  });

  $(".menubutton").click(function(){
    $(".toggle1:not(.menuform)").hide();
    $(".menuform").toggle();
  });

  $(".toggle1_close").click(function(){
    $(".toggle1").hide();
  });

  $.getJSON( openpne.apiBase + 'push/count.json?apiKey=' + openpne.apiKey, function(json){
    if(json.status=='success')
    {
      $pushHtml = $("#pushCountTemplate").tmpl(json.data);
      $("#notification_center").append($pushHtml);
    }else{
      alert(json.message);
    }
  });

});
