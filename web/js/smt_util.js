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
    $.getJSON( openpne.pushListUrl + '?apiKey=' + openpne.apiKey, function(json){
      if(json.status=='success')
      {
        $pushHtml = $("#pushListTemplate").tmpl(json.data);
        $('.divlink', $pushHtml).pushLink();
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

  $.getJSON( openpne.pushCountUrl +'?apiKey=' + openpne.apiKey, function(json){
    if(json.status=='success')
    {
      $pushHtml = $("#pushCountTemplate").tmpl(json.data);
      $("#notification_center").append($pushHtml);
    }else{
      alert(json.message);
    }
  });

});
