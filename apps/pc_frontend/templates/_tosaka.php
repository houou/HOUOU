<!-- NCFORM TMPL -->
<div class="ncform hide toggle1">
  <div class="row">
    <div class="span10 offset1 center white font14 toggle1_close">
      通知センター
    </div>
    <div class="span1">
      <?php echo op_image_tag('UPARROW', array('class' => 'toggle1_close')) ?>
    </div>
  </div>
  <div id="pushList" class="hide">
  </div>
  <div id="pushLoading" class="center"><?php echo op_image_tag('ajax-loader.gif') ?></div>
</div>
<!-- NCFORM TMPL -->

<script id="pushListTemplate" type="text/x-jquery-tmpl">
    <div class="{{if unread==false}}isread {{/if}}{{if category=="message" || category=="other"}}divlink {{/if}}row push"  data-notify-id="${id}" data-location-url="${url}" data-member-id="${member_id_from}">
      <div class="span3 push_icon">
        <img style="margin-left: 5px;" src="${icon_url}" class="rad4" width="48" height="48">
      </div>
      <div class="span9 push_content">
        <div class="row">
          {{if category=="link" && unread==false}}
          フレンドリンクが来ました。
          {{else}}
          {{html body}}
          {{/if}}
        </div>
        {{if category=="link"}}
        <div class="row">
            <button class="span2 btn primary small friend-notify-button friend-accept">YES</button>
            <button class="span2 btn small friend-notify-button friend-reject">NO</button>
            <div class="center hide" id="ncfriendloading"><?php echo op_image_tag('ajax-loader.gif') ?></div>
            <div class="center hide" id="ncfriendresultmessage"></div>
        </div>
        {{/if}}
      </div>
    </div>
</script>
<script id="pushCountTemplate" type="text/x-jquery-tmpl">
  {{if message!==0}}
  <span class="nc_icon1 label important" id="nc_count1">${message}</span>
  {{/if}}
  {{if link!==0}}
  <span class="nc_icon2 label important" id="nc_count2">${link}</span>
  {{/if}}
  {{if other!==0}}
  <span class="nc_icon3 label important" id="nc_count3">${other}</span>
  {{/if}}
</script>


<?php include_component('default', 'smtMenu') ?>

<!-- POSTFORM TMPL -->
<div class="postform hide toggle1">
  <div class="row">
    <div class="span10 offset1 center white font14 toggle1_close">
      投稿フォーム
    </div>
    <div class="span1">
      <?php echo op_image_tag('UPARROW', array('class' => 'toggle1_close')) ?>
    </div>
  </div>
  <div class="row posttextarea">
    <textarea id="tosaka_postform_body" class="span12" rows="4"></textarea>
  </div>
  <div class="row">
    <button id="tosaka_postform_submit" class="span10 offset1 btn small primary">POST</button>
  </div>
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
