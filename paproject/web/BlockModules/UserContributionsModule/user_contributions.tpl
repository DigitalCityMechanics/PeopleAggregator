<?php if(count($contributions) > 0){ ?>	

<?php 
	foreach($contributions  as $contribution):
		$show = ($contribution['show'] == 1) ? "show" : "hide";  
?>
<div class="divided">
	<div class="<?= (isset($contribution['type']) && ($contribution['type'] != "link" && $contribution['type'] != "question" && $contribution['type'] != "sugestion" && $contribution['type'] != "comment")) ? "offset-3" : ""; ?>">
		<?php 
			if(isset($contribution['type']) && !empty($contribution['type'])):	
				switch ($contribution['type']){
					case "attachment":
						echo "attachment";
						break;
					case "comment":
						echo "comment";
						break;
					case "image":
						echo "image";
		?>						
						<img src="http://placehold.it/90x60" class="callout" />
		<?php
						break;
					case "link":
						echo "link";
						break;
					case "suggestion":
						echo "suggestion";
						break;
					case "question":
						echo "question";
						break;
					case "video":
						echo "video";
						break;
					default:
						break;
				}
			endif;
		?>
		<p>
			Contributed on <a href="<?= $contribution['parent_url'] ?>"><?= $contribution['parent_title'] ?></a>
			<?php if(isset($contribution['created_at']) && !empty($contribution['created_at'])){
				        $parsedDate = null;
				        if($parsedDate = strtotime($contribution['created_at'])){ 		        
							echo "on" . (date("F j, Y", $parsedDate));
						}else{
							$parsedDate = null;
						}
				}
			?>							
		</p>
		<p><?= $contribution['content'] ?></p>
	</div>
</div>
<?php endforeach; ?>
<div class="pagination">
	<p><span class="prev">Prev</span><a class="current" href="#">1</a><a href="#">2</a> <a href="#">3</a><a href="#">4</a><a class="next" href="#">Next</a></p>
</div>
<?php } // end if ?>