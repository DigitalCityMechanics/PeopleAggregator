<?php
?>

<form name='comment_form' action="" method='post' onsubmit="javascript: return confirm_delete('<?= __("Are you sure you want  to post the comment?") ?>');">

<h3><?= __("Leave a Comment") ?></h3>
   <?php
      $form_fields = NULL;
      if( PA::$login_uid ) {
    ?>
      <h4><a href="<?php echo PA::$url . PA_ROUTE_USER_PUBLIC . '/' . PA::$login_uid ?>"><?php echo PA::$login_user->display_name ?></a> said:</h4>
    <?php
      }
      else {
        $form_fields .='<div class="form-block"><label for="name">Name</label><input type="text" name="name"  class="textbox normal" /></div>';
        $form_fields .='<div class="form-block"><label for="email">Email</label><input type="text" name="email"  class="textbox normal" />
</div>';
        $form_fields .='<div class="form-block"><label for="homepage"><?= __("Homepage") ?></label>
<input type="text" name="homepage"  class="textbox normal" /></div>';
      }
    ?>

      <?php echo $form_fields; ?>

<div class="form-block">
<textarea name="comment" cols="55" rows="5" id="Content"></textarea>
</div>
    
  <input type='submit' name='addcomment' class="submit no-tab" value='<?= __("Submit Comment") ?>' />
  <input type='hidden' name='cid' value="<?php echo $cid;?>" />
  <input type='hidden' name='ccid' value="<?php echo @$ccid;?>" />
  <input type='hidden' name='action' value="submitComment" />
</form>
  

