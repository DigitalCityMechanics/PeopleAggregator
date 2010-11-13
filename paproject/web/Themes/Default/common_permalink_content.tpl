<?php
require_once "api/Permissions/PermissionsHandler.class.php";
  $param_array = array('permissions' => 'view_abuse_report_form');
  $show_comments = isset($show_comments) ? $show_comments : true;
?>
<div class="post_info form-block">
      <?php
        if( $edit_link ) {
      ?>
      <a href="<?php echo $edit_link?>">edit</a>
      <?php
        }
      ?>
      <?php
        if( $delete_link) {
      ?>
        <a href="<?php echo $delete_link?>" onclick="javascript: return delete_content1();">delete</a>
      <?php
        }
     ?>
      <?php
        if( $approval_link) {
      ?>
        <a href="<?php echo $approval_link?>">approve</a>
      <?php
        }
      ?>
      <?php
        if( $denial_link) {
      ?>
        <a href="<?php echo $denial_link?>">deny</a>
      <?php
        }
      ?>
     </div>
   <?php
     echo $abuse_form;
    ?>
   <?php
      if($show_comments && $comments) {?>
          <h3>Comments</h3>
   <?php echo $comments;
      }
    ?>
    </table>
    <?php
      if ($show_comments && $comment_form) {
        echo $comment_form;
      }
    ?>
