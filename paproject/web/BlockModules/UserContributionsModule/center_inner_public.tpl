<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<link href="/Themes/Default/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" rel="stylesheet" />
<script src="/Themes/Default/javascript/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
//TODO: this file depends on the jquery binding and functions from UserParticipationModule's tpl file.
//		since we dont want to include jquery bindings and on page load twice, I left them out of this
//		page - Parag Jagdale - 10-19-10
	$(function() {
		$("#tabs-contributions").tabs();
	});
</script>
<?php global  $login_uid;?>

<div id="tabs-contributions">
	<ul>
	<?php if($mode == 0){ ?>
			<li><a href="#tabs-contributions-1">Contributions</a></li>
			<li><a href="#tabs-contributions-2">Thoughts</a></li>
	<?php }else{ ?>	
			<li><a href="#tabs-contributions-2">Posts</a></li>
			<li><a href="#tabs-contributions-1">Contributions</a></li>
	<?php } ?>
	</ul>
<?php if(count($contributions) > 0){ ?>	
	<div id="tabs-contributions-1">
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
<?php if(count($thoughts) > 0){ ?>	
	<div id="tabs-contributions-2">
		<div class="items">
		<?php 
			foreach($thoughts  as $thought){
			$show = ($thought['show'] == 1) ? "show" : "hide";  
	 ?>
			<div class="item <?php echo $show; ?>">
				<div class="above">
					<?php if(isset($thought['image'])){ ?>
						<img src="<?php echo $thought['image']; ?>" alt="thought image" style="width:100px;height:100px;" />
					<?php } ?>
					<h2><a href="#"><?php echo $thought['title']; ?></a></h2>
					<p><?php echo $thought['summary']; ?></p>
				</div>
				<div class="below">
					<a href="#"> thoughts</a>
				</div>
			</div>
		<?php } // end foreach ?>
		</div>
		<div class="tab-links">
			<a class="viewButton" href="#">View All</a>
			<a class="collapseButton" href="#">Collapse</a>
		</div>
	</div>
  </div>
<?php } // end if ?>	