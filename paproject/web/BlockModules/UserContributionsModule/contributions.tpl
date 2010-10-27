<?php if(count($contributions) > 0){ ?>	
	<div id="tabs-contributions-<?php echo ($mode == $USERMODE) ? '1' : '2'; ?>">
		<div class="items">
		<?php 
			foreach($contributions  as $contribution){
				$show = ($contribution['show'] == 1) ? "show" : "hide";  
		?>
			<div class="item <?php echo $show; ?>">
				<div class="above">
					<?php if(isset($contribution['parent_image'])){ 
					$width = 100;
					$height = 100;
					if(isset($contribution['parent_image_width']) && is_Numeric($contribution['parent_image_width'])){
						$width = $contribution['parent_image_width'];
					}
					if(isset($contribution['parent_image_height']) && is_Numeric($contribution['parent_image_height'])){
						$height = $contribution['parent_image_height'];
					}
				?>
						<img src="<?php echo $contribution['parent_image']; ?>" alt="contribution image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;"/>
					<?php } ?>
					<h2><a href="<?php echo $contribution['parent_url'] ?>" title="View"><?php echo $contribution['parent_title']; ?></a></h2>
					<p><?php echo $contribution['comment']; ?></p>
				</div>
				<div class="below">
					<a href="#"><?php echo $contribution['participant_count']; ?> Participants</a> | <a href="#"><?php echo $contribution['contribution_count']; ?> Contributions</a>
				</div>
			</div>
		<?php } // end foreach ?>
		</div>
		<div class="tab-links">
			<a class="viewButton" href="#">View All</a>
			<a class="collapseButton" href="#">Collapse</a>
		</div>
	</div>
<?php } // end if ?>