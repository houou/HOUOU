<?php use_helper('Javascript') ?>
<script id="joinCommunityListTemplate" type="text/x-jquery-tmpl">
  <div class="span3">
    <div class="row_memberimg row"><a href="${community_url}"><img src="${community_image_url}" class="rad10" width="57" height="57"></a></div>
    <div class="row_membername font10 row"><a href="${community_url}">${name}</a> (${member_count})</div>
  </div>
</script>
<script type="text/javascript">
$(function(){
  $.getJSON( '<?php echo app_url_for('api', 'member/communities.json', array()); ?>?targetid=<?php echo $member->getId(); ?>&apiKey=' + openpne.apiKey, function(json) {
    $('#joinCommunityListTemplate').tmpl(json.data).appendTo('#memberJoinCommunityList');
    $('#memberJoinCommunityList').show();
    $('#memberJoinCommunityListLoading').hide();
  });
});
</script>

<hr class="toumei" />
<div class="row">
  <div class="gadget_header span12"><?php echo __('%community% List', array('%community%' => $op_term['community'])) ?></div>
</div>
<hr class="toumei" />
<div class="row hide" id="memberJoinCommunityList" style="margin-left: 0;">
</div>
<div class="row" id="memberJoinCommunityListLoading" style="margin-left: 0; text-align: center;">
<?php echo op_image_tag('ajax-loader.gif', array()) ?>
</div>
