<?php 
require_once "api/Permissions/PermissionsHandler.class.php";

	$permission_to_post = PermissionsHandler::can_user(PA::$login_uid, array('permissions' => 'post_to_community'));
	
  $form_action = (isset($form_action) && $form_action != '') ? $form_action : PA::$url ."/post_content.php";
  if ( $ccid > 0 ) {
  	$ccid_string = "&ccid=".$ccid;
  	$form_action .= "?ccid=$ccid";
		if (($group_access == ACCESS_PRIVATE) || ($group_reg == REG_INVITE)) {
			// content published in a private Group!
			// turn off full routing for private groups
			PA::$config->simple['omit_routing'] = true;
			// no routing to homepage either!
			$permission_to_post = false;
		}
  } else {
    $ccid_string = "";
  }
  
?>

<form name="formCreateContent" method="post" enctype="multipart/form-data" action="<?php echo $form_action;?>" onsubmit="return sanitize_input(this);">
<div id="content_post">
  <div class="steps">
    <ul>
    <?php if ($is_edit) { ?>
      <li><h1><?= __("Edit Your Post") ?></h1></li>
    <? } else { ?>
      <li><h1><?= __("Create Your Post") ?></h1></li>
    <? } ?>
    </ul>
    <ul id="create_blog_form">
        <li>
          <?php echo $center_content; ?>
        </li>
      </ul>
      <ul>
    </ul>
    <ul id="publish_post">
        <li>
           <input type="hidden" name="save_publish_post" value="1" id="save_publish_post" />
           <input type="hidden" name="publish" value="<?php echo (!$is_edit) ? 'Publish Post' : 'Update Post'; ?>">
           <input type="submit" name="publish_post" class="submit" value="<?php echo (!$is_edit) ? 'Publish Post' : 'Update Post'; ?>" />
           or <a href="<?= PA::$url . PA_ROUTE_USER_PRIVATE  ?>">cancel</a>
        </li>
      </ul>
      </div>
    </div>
</form>    
<br clear="all" />
<br clear="all" />
<script>
$(document).ready(
  function() {
    // add onChange to form elements to have dirtyBit set
    $('input, select, textarea').change(
      function() {
        // alert("don't forget to save!");
        window.dirtyBit = true;
      }
    );

		// mark links inn the PostContentModule
		$("#PostContentModule a").addClass('internal');
    // add "You are leaving this section" alerts
    $("a").not('.internal').click(
      function() {
        if (window.dirtyBit) {
          // only do the are you sure if there have been changes to the form
          // onChange for form elements set the dirtyBit to ture
          var url = $(this).attr('href');
          var question = "<?=__("The post you are composing will be lost if you continue, are you sure you want to leave  without saving?")?>";
          var check = confirm(question);
          if (check == false) {
            return false;
          } 
          document.location.href = url;
        }
      }
    );
	}
);
</script>
