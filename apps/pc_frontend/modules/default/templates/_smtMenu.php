<!-- MENUFORM TMPL -->
<div class="menuform hide toggle1">
  <hr class="toumei">
  <div class="row">
    <div class="span10 offset1 center white font14 toggle1_close">
      MENU
      <hr class="toumei">
    </div>
    <div class="span1">
      <?php echo op_image_tag('UPARROW', array('class' => 'toggle1_close')) ?>
    </div>
  </div>


  <hr class="toumei">

  <div class="menu-middle row">
    <div class="span11 offset1">
      <a href="<?php echo url_for('@homepage', array('absolute' => 'true')); ?>" class="btn">ホーム</a>
      <a href="<?php echo url_for('@member_profile_mine'); ?>" class="btn">プロフィール確認</a>
      <a href="<?php echo url_for('@member_editProfile'); ?>" class="btn">プロフィール変更</a>
      <a href="<?php echo url_for('@homepage', array('absolute' => 'true')); ?>community/1" class="btn">ALLコミュニティ</a>
      <a href="<?php echo url_for('@member_config'); ?>" class="btn">設定変更</a>
      <a href="<?php echo url_for('@member_logout'); ?>" class="btn">ログアウト</a>
    </div>
  </div>
  <hr class="toumei">
  <hr class="toumei">
  <?php echo op_image_tag('SEPALATOR.png', array('height' => '6', 'width' => '320')) ?>
</div>
<!-- MENUFORM TMPL -->
