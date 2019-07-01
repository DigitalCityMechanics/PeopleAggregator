<?php global $app;
  $alb = (!empty($_GET['album_id'])) ? '&album_id='.$_GET['album_id']:null;
  $current_url = PA::$url . $app->current_route;
?>
<?php if (empty($frnd_list)) { ?><h1><?php echo ucfirst($links['album_name']);?></h1><?php } ?>
<?php 
  if (!empty($frnd_list)) { ?>
    <div class="search_gallery"> Friend
      <select id="frnd_list" class="select-txt" onchange="select_frnd()">
        <?php for ($k=0; $k<count($frnd_list); $k++) { ?>
          <?php if ($frnd_list[$k]['id'] == $_GET['uid']) {
                $selected = "selected=\"selected\""; 
              }
              else {
                $selected = " ";
              }
            ?>
          <option <?=$selected?> value="<?=$frnd_list[$k]['id']?>"><?=$frnd_list[$k]['name']?></option>
        <?php } ?>
      </select>
    </div>
 <?php } ?>
<?php if (!empty ($my_all_album)) { ?> 
  <div class="search_gallery"><?if (!empty($frnd_list)) { echo __('Album'); } else { echo __('Select Album');} ?>
    <select id="album_name" class="select-txt" onchange="select_album()">
      <?php for ($k=0; $k<count($my_all_album); $k++) { ?>
        <?php if ($my_all_album[$k]['id'] == $links['album_id']) {
            $selected = "selected=\"selected\""; 
          }
          else {
            $selected = " ";
          }
        ?>
        <option <?=$selected?> value="<?=$my_all_album[$k]['id']?>"><?=$my_all_album[$k]['name']?></option>
      <?php } ?>
    </select>
  </div>
<?php } ?>
<?php $display_links = ($show_view == 'thumb') ? 'List View': 'Thumb View';?>
<?php $href_links = ($show_view == 'thumb') ? '/gallery=list&uid=' . $_GET['uid']: '/gallery=thumb&uid=' . $_GET['uid'];?>
<div id="buttonbar">
  <ul> 
    <li><a href="<?= $current_url . $href_links;?>"><?php echo $display_links;?></a></li>
    <?php if ((!isset(PA::$page_uid) || (PA::$login_uid == PA::$page_uid)) && empty($_GET['view'])) { ?>
      <li><a href="<?= PA::$url . "/upload_media.php?type=Images" . $alb . '&uid=' . $_GET['uid']  ?>"><?= __("Upload") ?></a></li>
    <?php } ?>
  </ul>
</div> 
<form enctype="multipart/form-data" name="image_upload" id="image_upload" action="" method="post">
  <input type="hidden" name="action" value="deleteMedia" />
  <input type="hidden" name="media_id" id="media_id" value="" />
  <?php
   switch ($show_view) {
     case 'thumb':
       require "thumbnail.tpl";
     break;
     case 'list' :
       require "list.tpl";
     break;
   }
    ?>
<input type="hidden" name="media_type" value="Images">  
<input type="hidden" name="album_id" value="<?=$links['album_id']?>">  
</form>