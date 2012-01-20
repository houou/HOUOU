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
  });

  $(".menubutton").click(function(){
    $(".toggle1:not(.menuform)").hide();
    $(".menuform").toggle();
  });

  $(".toggle1_close").click(function(){
    $(".toggle1").hide();
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
  <div class="row">
  <hr class="toumei">
  <hr class="toumei">
    <div class="span12 center">
      <img src="http://p.pne.jp/d/201201162250.png" alt="" />
    </div>
  </div>
  <hr class="toumei">
  <hr class="toumei">
  <?php echo op_image_tag('SEPALATOR.png', array('height' => '6', 'width' => '320')) ?>
</div>
<!-- NCFORM TMPL -->

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
          <span class="nc_icon1 label important">1</span>
          <span class="nc_icon2 label important">2</span>
          <span class="nc_icon3 label important">3</span>
        </div>
        <div class="span3 offset1 center"><?php echo op_image_tag('POST.png', array('height' => '32', 'class' =>'postbutton')) ?></div>
      </div>
    </div>
  </div>
</div>
