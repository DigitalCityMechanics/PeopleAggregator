<?php
   $img_desktop_info = get_network_image();
   $style = null;
   $extra = unserialize($network_info->extra);
   if (!empty($img_desktop_info) && @$extra['basic']['header_image']['display'] == DESKTOP_IMAGE_DISPLAY) {
       $img_desktop_info = manage_user_desktop_image($extra['basic']['header_image']['name'], $extra['basic']['header_image']['option']);
       $style = ' style="background: url('.$img_desktop_info['url'].') '.$img_desktop_info['repeat'].'"';
   }
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo wordwrap(strip_tags($network_info->name),60,1); ?>

      <?php if ($network_info->tagline) { ?>
      <small><?php echo wordwrap(strip_tags($network_info->tagline),60,1);?></small>
      <?php } ?>      
  </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="<?= PA::$url . PA_ROUTE_HOME_PAGE ?>"><i class="fa fa-home"></i> Dashboard</a></li>
    </ol>
    <div class="jumbotron" <?php echo $style?>>

    </div>             
</section>