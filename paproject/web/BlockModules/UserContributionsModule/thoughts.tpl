<?php if(count($thoughts) > 0){ ?>	
	<div id="tabs-contributions-<?php echo ($mode == $USERMODE) ? '2' : '1'; ?>">
		<div class="items">
		<?php 
			foreach($thoughts  as $thought){
			$show = ($thought['show'] == 1) ? "show" : "hide";
	 ?>
			<div class="item <?php echo $show; ?>">
				<div class="above">
					<?php if(isset($thought['image'])){ ?>
						<a href="<?php echo isset($thought['url']) ? $thought['url'] : ''; ?>"><img src="<?php echo $thought['image']; ?>" alt="thought image" style="<?php echo isset($thought['image_width']) ? 'width:'.$thought['image_width'].'px;' : ''; ?><?php echo isset($thought['image_height']) ? 'height:'.$thought['image_height'].'px;' : ''; ?>" /></a>
					<?php } ?>
					<h2><a href="<?php echo isset($thought['url']) ? $thought['url'] : ''; ?>"><?php echo isset($thought['title']) ? $thought['title'] : ''; ?></a></h2>
					<p><?php echo isset($thought['summary']) ? $thought['summary'] : ''; ?></p>
				</div>
				<div class="below">
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