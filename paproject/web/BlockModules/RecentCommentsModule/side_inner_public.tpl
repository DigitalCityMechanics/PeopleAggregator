<ol class="comments divided">
<?php
  if(count($links) > 0) {
    for ($i=0; $i<count($links); $i++) {
      $date = content_date($links[$i]['created']);
      $comment = $links[$i]['comment'];
      $comment = _out(chop_string($comment,48));
      $post_title = $links[$i]['post_title'];
      $post_title = _out(chop_string($post_title,18));
      $author = $links[$i]['name'];
      $author_id = $links[$i]['user_id'];
      $comment = str_replace('<br />',' ',$comment);
      $avatar = isset($links[$i]['picture']) ? $links[$i]['picture'] : '/files/default.png';
?>
<li class="offset-1">
      <img src="<?php echo $avatar; ?>" class="callout" height="40" width="40" />
       <p><strong><a href="<?= PA::$url . PA_ROUTE_USER_PUBLIC . '/' . $author_id ?>"><?= $author ?></a></strong></p>
       <p><?php echo $comment;?></p>
</li>

<?} 
} else { ?>
    <li><?= __('No comments posted yet.'); ?></li>
<?php } ?>
</ol>
