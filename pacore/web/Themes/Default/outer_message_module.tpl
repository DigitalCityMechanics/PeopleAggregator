<?
  if ( $html_block_id ) {
     $id = "id=\"$html_block_id\"";
  }   
?>
  <div class="wide_content message_layout" <?php echo $id;?>>
  <?php if($title) {?><h1><?php echo $title;?></h1><?php } ?>
    <?php echo $inner_HTML;?>
  </div>
