<?php

 
require_once "api/Permissions/PermissionsHandler.class.php";
require_once "web/includes/classes/TinyMCE.class.php";
  $tiny = new TinyMCE('blog');
  echo $tiny->installTinyMCE();

/*
require_once "web/includes/tinymce.php";
install_tinymce('full');
*/
  if(!empty($_REQUEST['ccid'])) {
    $permission_to_upload = PermissionsHandler::can_group_user(PA::$login_uid, $_REQUEST['ccid'], array('permissions' => 'upload_images, upload_videos'));
  } else {
    $permission_to_upload = PermissionsHandler::can_network_user(PA::$login_uid, PA::$network_info->network_id, array('permissions' => 'upload_images, upload_videos'));
  }
?>
<fieldset>
  <?php echo isset($message) ? '<div class="message">'.$message.'</div>'."\n" : ''; ?>
  <div class="field" >
    <label for="title"><span class="required"> * </span><b> <?= __("Title") ?>:</b></label>
    <input type="text" name="blog_title" class="text long" id="title" style="width:647px;" value="<?=stripslashes($blog_title)?>"/>
  </div>
  <input name="blog_type" type="hidden" value="<?php echo $blog_type; ?>" />
  <input name="redirect" type="hidden" value="<?php echo urldecode(stripslashes($redirect)); ?>" />
  <div class="field">
    <textarea name="description" id="description" class="long" cols="89" rows="30"><?php echo htmlspecialchars($body) ?></textarea>
  </div>
</fieldset>    
<br clear="all" />

<?php if (!empty(PA::$config->simple['use_attachmedia']) && $permission_to_upload) { 
$file = getShadowedPath('web/BlockModules/PostContentModule/attach_media.tpl.php');
include $file;
?>
<!--
<fieldset id='media'>
  <legend><a><b><?= __('Add Image or Video')?></b></a></legend>
    <input type="file" name="sb_action_upload_file_name/media/file" value="Choose File" />
</fieldset>
<br clear="all" />
-->
<? } ?>

<fieldset id='tags'>
  <legend><a><b><?= __("Tags") ?></b></a></legend>
  <input type="text" class="text long" id="tags"  name="tags" value="<?=stripslashes($tag_entry)?>" style="width:647px;" />
  <br /><?= __("Separate tags with commas") ?>
</fieldset>
  <input type="hidden" name="cid" value="<?php echo $cid ?>"/> 
  <? if (isset($group_id)) { ?>
  <input type="hidden" name="gid" value="<?php echo $group_id ?>" />
  <? } ?>
  <input type="hidden" name="ccid" value="<?php echo $ccid ?>" />
