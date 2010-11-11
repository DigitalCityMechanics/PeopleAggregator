 <h1><a href="<?= htmlspecialchars($permalink) ?>"><?php echo $contents->title;?></a></h1>
 <h3 class="meta">
   <?php echo '<a href="'.PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $user_id . '">'.uihelper_resize_mk_user_img($picture_name, 20, 20, 'alt=""').'</a>'; ?>
   <a href="<?php echo $user_link?>"><?php echo $user_name?></a> 
   on <?=date("F d, Y", $contents->created);?>
 </h3>

 <?php echo $contents->body;?>

<?php
  require "common_permalink_content.tpl";
?>
