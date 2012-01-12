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
      <?php if ($navs): ?>
      <?php foreach ($navs as $nav): ?>
      <?php if (op_is_accessible_url($nav->uri)): ?>
      <?php echo link_to($nav->caption, $nav->uri, array('class' => 'btn', 'id' => sprintf('smtMenu_%1', op_url_to_id($nav->uri, true)))) ?>
      <?php endif ?>
      <?php endforeach ?>
      <?php endif ?>
    </div>
  </div>
  <hr class="toumei">
  <hr class="toumei">
  <?php echo op_image_tag('SEPALATOR.png', array('height' => '6', 'width' => '320')) ?>
</div>
<!-- MENUFORM TMPL -->
