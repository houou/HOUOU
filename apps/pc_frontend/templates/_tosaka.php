<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.js"></script>
<script type="text/javascript" src="/js/smt_notify.js"></script>
<script type="text/javascript">
//-----------------------------------
//COMMENT BUTTON NAVIGATION
$(document).ready(function(){
  $(".commentbutton").click(function(){
    $(".commentform").toggle();
    $(".commentbutton").toggle();
  });
});

//-----------------------------------
//TOSAKA BUTTON NAVIGATION
$(document).ready(function(){
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
    $.getJSON('<?php echo app_url_for('api', 'push/search.json', array()) ?>?apiKey=' + openpne.apiKey, function(json){
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

  $.getJSON('<?php echo app_url_for('api', 'push/count.json', array()) ?>?apiKey=' + openpne.apiKey, function(json){
    if(json.status=='success')
    {
      $pushHtml = $("#pushCountTemplate").tmpl(json.data);
      $("#notification_center").append($pushHtml);
    }else{
      alert(json.message);
    }
  });

});
</script>


<!-- NCFORM TMPL -->
<div class="ncform hide toggle1">
  <hr class="toumei">
  <div class="row">
    <div class="span10 offset1 center white font14 toggle1_close">
      通知センター
      <hr class="toumei">
    </div>
    <div class="span1">
      <?php echo op_image_tag('UPARROW', array('class' => 'toggle1_close')) ?>
    </div>
  </div>
  <div id="pushList" class="hide">
  </div>
  <div id="pushLoading" class="center"><?php echo op_image_tag('ajax-loader.gif', array()) ?></div>
</div>
<!-- NCFORM TMPL -->

<script id="pushListTemplate" type="text/x-jquery-tmpl">
    <div class="row push" data-location-url="${url}" data-member-id="${member_id_from}">
      <div class="{{if category=="message" || category=="other"}}divlink {{/if}}row" data-location-url="${url}" data-member-id="${member_id_from}">
      <hr class="toumei">
      <div class="span3">
        <img style="margin-left: 5px;" src="${icon_url}" class="rad4" width="48" height="48">
      </div>
      <div class="span9" style="margin-left: -13px;">
      {{if category=="friend"}}
        <div class="row">
        {{html body}}
        </div>
        <div class="row">
            <button class="span2 btn primary small">YES</button>
            <button class="span2 btn small">NO</button>
        </div>
      {{/if}}
      {{if category=="message"}}
        <div class="link_message">
        {{html body}}
        </div>
      {{/if}}
      {{if category=="other"}}
        <div class="link_other">
        {{html body}}
        </div>
      {{/if}}
      </div>
      <hr class="toumei">
    </div>
    </div>
    <hr class="gray">
</script>
<script id="pushCountTemplate" type="text/x-jquery-tmpl">
  {{if message.unread!=='0'}}
  <span class="nc_icon1 label important" id="nc_count1">${message.unread}</span>
  {{/if}}
  {{if link.unread!=='0'}}
  <span class="nc_icon2 label important" id="nc_count2">${link.unread}</span>
  {{/if}}
  {{if other.unread!=='0'}}
  <span class="nc_icon3 label important" id="nc_count3">${other.unread}</span>
  {{/if}}
</script>


<?php include_partial('default/smtMenu') ?>

<!-- POSTFORM TMPL -->
<div class="postform hide toggle1">
  <hr class="toumei">
  <div class="row">
    <div class="span10 offset1 center white font14 toggle1_close">
      投稿フォーム
      <hr class="toumei">
    </div>
    <div class="span1">
      <?php echo op_image_tag('UPARROW', array('class' => 'toggle1_close')) ?>
    </div>
  </div>
  <div class="row">
    <textarea class="posttextarea span12" rows="4" ></textarea>
  </div>
  <hr class="toumei">
  <div class="row">
    <button class="span10 offset1 btn small primary" >POST</button>
  </div>
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <hr class="toumei">
  <?php echo op_image_tag('SEPALATOR.png', array('height' => '6', 'width' => '320')) ?>
</div>
<!-- POSTFORM TMPL -->

<div id="slot_tosaka">
  <div class="row">
    <div class="span12">
      <div class="row">
        <div class="span4"><?php echo op_image_tag('LOGO.png', array('height' => '32', 'class' => 'menubutton')); ?></div>
        <div id="notification_center" class="span4 center"><?php echo op_image_tag('NOTIFY_CENTER.png', array('height' => '32', 'class' => 'ncbutton')) ?>
        </div>
        <div class="span3 offset1 center"><?php echo op_image_tag('POST.png', array('height' => '32', 'class' =>'postbutton')) ?></div>
      </div>
    </div>
  </div>
</div>
