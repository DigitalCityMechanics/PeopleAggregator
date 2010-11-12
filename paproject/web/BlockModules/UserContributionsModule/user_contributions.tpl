<div class="divided">
<?php 
if(count($contributions) > 0): 

	if(isset($contributions[0]['default']) && $contributions[0]['default'] == true): ?> 
		<p><?=$contributions[0]['content']?></p>
		
	<?php			
	else:
		foreach($contributions  as $contribution):
			$typeClass = " "; 
			if((isset($contribution['type']))){
				$classToSet = "";
				switch ($contribution['type']){
					case "attached_file":
						$classToSet = "dnld document";
						break;
					case "video":
						$classToSet = "dnld video";
						break;
					case "link":
						$classToSet = "dnld link";
						break;
					case "image":
						$classToSet = "dnld image";
						break;
					case "link":
						$classToSet = "dnld link";
						break;
					default:
						break;
				}
				$typeClass .= $classToSet;
			}
		?>
			<div class="<?= $typeClass ?>">
				<?php 
				if(isset($contribution['type']) && !empty($contribution['type'])):	
					switch ($contribution['type']){
						case "attachment":
							break;
						case "comment":
							break;
						case "image":
							if(isset($contribution['attachment_url'])):
								$linkText = (isset($contribution['link_text']) && !empty($contribution['link_text'])) ? $contribution['link_text'] : "View Image";
							?>
								<a href="<?= $contribution['attachment_url']?>"><?= $linkText ?></a>
							<?php endif; ?>	
						<?php /* if(isset($contribution['attachment_url']) && !empty($contribution['attachment_url'])): ?>
							<img src="<?= $contribution['attachment_url'] ?>" class="callout">
						<?php endif;*/
							break;
						case "link":
						case "ppl_agg_contribution":
							if(isset($contribution['link_url'])):
								$linkText = (isset($contribution['link_text']) && !empty($contribution['link_text'])) ? $contribution['link_text'] : "Visit Link";
							?>
								<a href="<?= $contribution['link_url']?>"><?= $linkText ?></a>
							<?php endif;
							break;
						case "suggestion":
							break;
						case "question":
							break;
						case "video":
							if(isset($contribution['link_url'])):
								$linkText = (isset($contribution['link_text']) && !empty($contribution['link_text'])) ? $contribution['link_text'] : "Visit Link";
							?>
								<a href="<?= $contribution['link_url']?>"><?= $linkText ?></a>
							<?php endif;
							 if(isset($contribution['attachment_url']) && !empty($contribution['attachment_url'])): ?>
								<?= $contribution['attachment_url'] ?>
							<?php endif; 
						break;
						case "top_level_contribution":
							break;
						case "attached_file":
						?>						
						<?php if(isset($contribution['attachment_url']) && !empty($contribution['attachment_url'])): ?>
							<a href="<?= $contribution['attachment_url'] ?>">
								<?php echo (isset($contribution['link_text']) && !empty($contribution['link_text'])) ? $contribution['link_text'] : "View File";  ?>
							</a>
						<?php endif;						
							break;
						default:
							break;
					}
				endif;
				?>
				<p><?= $contribution['content'] ?></p>

				<p class="profile-meta">
					Contributed to <a href="<?= $contribution['parent_url'] ?>"><?= $contribution['parent_title'] ?></a>
					<?php if(isset($contribution['created_at']) && !empty($contribution['created_at'])){
							$parsedDate = null;
							if($parsedDate = strtotime($contribution['created_at'])){ 		        
								echo "on " . (date("F j, Y", $parsedDate));
							}else{
								$parsedDate = null;
							}
						}
					?>							
				</p>	
			</div>

		<?php endforeach; ?>		
	<?php endif; ?>
<?php endif; ?>
</div>
<div class="pagination">
	<?php if( $page_links ) { ?>
		<div class="pagination">
			<?php echo $page_links; ?>
		</div>
	<?php }  ?>
</div> 