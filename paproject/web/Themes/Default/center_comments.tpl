<?php
require_once "api/Permissions/PermissionsHandler.class.php";
  $param_array = array('permissions' => 'view_abuse_report_form');
  $total_comments = count( $comments );
  if( $total_comments ) {
?>
  <?php
  foreach( $comments as $comment ) {
    // output filtering
    $comment['comment'] = _out($comment['comment']);
  ?>
      <?php
        if( $comment['user_id'] == -1 ) {
      ?>
      <a rel="nofollow" href="<?php echo htmlspecialchars($comment['homepage'])?>"><?php echo $comment['name']?></a> on <?=date("F d, Y", $comment['created']); ?> said:
      <?php
        }
        else {
        echo '<p><strong>';
        echo '<a href="'.PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $comment['user_id'].'">'.uihelper_resize_mk_user_img($comment['picture'], 20, 20, 'alt=""').'</a>';
      ?>

      <a href="<?php echo PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $comment['user_id']?>"><?php echo $comment['name']?></strong>  on <?=date("F d, Y", $comment['created']);?> </a>
said:</p>
      <?php } ?>
   <?php echo nl2br(stripslashes($comment['comment']));?>
    <div class="post_info form-block">
      <?php
        $params = array('comment_info'=>array('user_id'=>$comment['user_id'], 'content_id'=>$comment['content_id']), 'permissions'=>'delete_comment');
        echo '</div>';
        if (!empty(PA::$login_uid)) {
          if(PermissionsHandler::can_user(PA::$login_uid, $params)) {
            echo '<a class="moderate" href="'.PA::$url .'/deletecomment.php?comment_id='.$comment['comment_id'].'" onclick="return confirm_delete(\'Are you sure you want to delete this comment ? \');">Delete</a>';
          }
          if(PermissionsHandler::can_user(PA::$login_uid, $param_array) && ($comment['user_id'] != PA::$login_uid)) {
          echo '<a class="moderate" href="javascript: return void();" onclick = showhide_block("report_abuse_div_'.$comment['comment_id'].'"); >Report abuse </a>';
          }
        }
      ?>
   <?php
     $id = $comment['comment_id'];
     $param['type'] = 'comment';
     $param['div_id'] = "report_abuse_div_$id";
     $param['id'] = $comment['comment_id'];
     echo uihelper_create_abuse_from($param);
    ?>
  <?php

    }
  ?>
<?php
  }
?>
