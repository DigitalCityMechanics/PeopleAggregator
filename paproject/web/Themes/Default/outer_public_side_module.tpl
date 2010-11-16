<?php
   
  if ( $html_block_id ) {
     $id = "id=\"$html_block_id\"";
  }
?>
<div class="mod" <?php echo $id;?>>
 <?php if($title) {?><h3><?php echo $title;?></h3><? } ?>
 <div class="mod-content">
	 <?php echo $inner_HTML; ?>
	  <?php 
	    if ($view_all_url) {
  	?>   
	      <div class="view_all"><a href="<?php echo $view_all_url?>"><?= __("view all") ?></a></div>
	  <?php 
	    }
  	?>
  </div>
</div>