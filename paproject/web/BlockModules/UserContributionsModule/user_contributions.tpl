<?php if(count($contributions) > 0){ ?>	

<?php 
	foreach($contributions  as $contribution):
		$show = ($contribution['show'] == 1) ? "show" : "hide";  
?>
<div class="divided">
	<div class="<?= (isset($contribution['type']) 
					&& ($contribution['type'] != "link" 
							&& $contribution['type'] != "question" 
							&& $contribution['type'] != "suggestion"  
							&& $contribution['type'] != "video" 
							&& $contribution['type'] != "comment")) ? "offset-3" : ""; ?>">
		<?php 
			if(isset($contribution['type']) && !empty($contribution['type'])):	
				switch ($contribution['type']){
					case "attachment":
						break;
					case "comment":
						break;
					case "image":
		?>						
						<?php if(isset($contribution['attachment_url']) && !empty($contribution['attachment_url'])): ?>
								<img src="<?= $contribution['attachment_url'] ?>" class="callout" style="width:70px;height70px;">
						<?php endif; ?>					
		<?php
						break;
					case "link":
						if(isset($contribution['link_url'])){
							$linkText = (isset($contribution['link_text']) && !empty($contribution['link_text'])) ? $contribution['link_text'] : "Visit Link";
		?>
							<a href="<?= $contribution['link_url']?>"><?= $linkText ?></a>
		<?php
						}
						break;
					case "suggestion":
						break;
					case "question":
						break;
					case "video":
?>
						<?php if(isset($contribution['embed_code']) && !empty($contribution['embed_code'])): ?>
								<?= $contribution['embed_code'] ?>
						<?php endif; ?>
<?php
						break;
					case "top_level_contribution":
						//echo "top_level_contribution";
						break;
					case "ppl_agg_contribution":
						//echo "ppl_agg_contribution";
						break;
					case "suggested_action":
						//echo "suggested_action";
						break;
					case "attached_file":
						//echo "attached_file";
						break;
					default:
						break;
				}
			endif;
		?>
		<p><?= $contribution['content'] ?></p>
							
		<p>
			Contributed to <a href="<?= $contribution['parent_url'] ?>"><?= $contribution['parent_title'] ?></a>
			<?php if(isset($contribution['created_at']) && !empty($contribution['created_at'])){
				        $parsedDate = null;
				        if($parsedDate = strtotime($contribution['created_at'])){ 		        
							echo "on " . (date("F j, Y g:ia", $parsedDate));
						}else{
							$parsedDate = null;
						}
				}
			?>							
		</p>		
	</div>
</div>

<?php endforeach; ?>
<!-- <div class="pagination">
	<p><span class="prev">Prev</span><a class="current" href="#">1</a><a href="#">2</a> <a href="#">3</a><a href="#">4</a><a class="next" href="#">Next</a></p>
</div> -->
<?php } // end if ?>