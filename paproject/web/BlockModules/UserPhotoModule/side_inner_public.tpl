<?php 
// global var $_base_url has been removed - please, use PA::$url static variable
 
?><div class="module_html">
<a href="<?= PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $uid?>"><?php echo uihelper_resize_mk_user_img($picture, $picture_width, $picture_height, 'alt="User Picture"'); ?></a>
</div>
