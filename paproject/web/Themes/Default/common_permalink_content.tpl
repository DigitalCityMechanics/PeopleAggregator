<?php
require_once "api/Permissions/PermissionsHandler.class.php";
  $param_array = array('permissions' => 'view_abuse_report_form');
?>
<div class="post_info form-block">
      <?php
        if( $edit_link ) {
      ?>
      <a href="<?php echo $edit_link?>" class="button">edit</a>
      <?php
        }
      ?>
      <?php
        if( $delete_link) {
      ?>
        <a href="<?php echo $delete_link?>" onclick="javascript: return delete_content1();" class="button">delete</a>
      <?php
        }
     ?>
      <?php
        if( $approval_link) {
      ?>
        <a href="<?php echo $approval_link?>" class="button">approve</a>
      <?php
        }
      ?>
      <?php
        if( $denial_link) {
      ?>
        <a href="<?php echo $denial_link?>" class="button">deny</a>
      <?php
        }
      ?>
     </div>
   <?php
     echo $abuse_form;
    ?>
   <?php
      if($comments) {?>
          <h3>Comments</h3>
   <?php echo $comments;
      }
    ?>
    </table>
    <?php
      if ($comment_form) {
        echo $comment_form;
      }
    ?>
