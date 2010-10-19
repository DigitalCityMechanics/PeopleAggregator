<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<link href="/Themes/Default/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" rel="stylesheet" />
<script src="/Themes/Default/javascript/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
		$(".collapseButton").hide();
		$(".viewButton").click(function(e){
			$(this).parent().siblings('.item').each(function(){
				if($(this).hasClass('hide')){
					$(this).removeClass('hide');
					$(this).addClass('show shown');
				}
			});
			$(this).siblings('.collapseButton').show();
			$(this).hide();
			e.preventDefault();
		});
		
		$(".collapseButton").click(function(e){
			$(this).parent().siblings('.item').each(function(){
				if($(this).hasClass('shown')){
					$(this).addClass('hide');
					$(this).removeClass('show shown');
				}
			});
			$(this).siblings('.viewButton').show();
			$(this).hide();
			e.preventDefault();
		});
	});
</script>

<style type="text/css">
div.item {
	background-color:#FFF;
	margin-bottom:10px;
	padding:4px;
}
div.item img {
	float:left;
	margin:0 13px 5px;
}
div.item h2 {font-size:100%;}
div.item div.below {clear:both;padding:5px;}
div.tab-links{text-align:right; color:#999; font-size:11px; text-transform:uppercase;}
div.show.item{display:block;}
div.hide.item{display:none;}
</style>

<?php global  $login_uid;?>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Conversations</a></li>
		<li><a href="#tabs-2">Issues</a></li>
		<li><a href="#tabs-3">Following</a></li>
	</ul>
<?php if(count($conversations) > 0){ ?>
	<div id="tabs-1">
	<?php 
		foreach($conversations  as $conversation){
			$show = ($conversation['show'] == 1) ? "show" : "hide";  
	?>
		<div class="item <?php echo $show; ?>">
			<div class="above">
				<?php if(isset($conversation['image'])){ 
					
					$width = 100;
					$height = 100;
					if(isset($conversation['image_width']) && is_Numeric($conversation['image_width'])){
						$width = $conversation['image_width'];
					}
					if(isset($conversation['image_height']) && is_Numeric($conversation['image_height'])){
						$height = $conversation['image_height'];
					}
					?>
					<img src="<?php echo $conversation['image']; ?>" alt="Conversation image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;"/>
				<?php } ?>
				<h2><a href="<?php echo $conversation['url']; ?>"><?php echo $conversation['title']; ?></a></h2>
				<p><?php echo $conversation['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $conversation['participant_count']; ?> Participants</a> | <a href="#"><?php echo $conversation['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
		<div class="tab-links">
			<a class="viewButton" href="#">View All</a>
			<a class="collapseButton" href="#">Collapse</a>
		</div>
	</div>
<?php } // end if ?>	

<?php if(count($issues) > 0){ ?>
	<div id="tabs-2">
	<?php 
		foreach($issues  as $issue){
			$show = ($issue['show'] == 1) ? "show" : "hide"; 
	?>
		<div class="item <?php echo $show; ?>">
			<div class="above">
				<?php if(isset($issue['image'])){
				
					$width = 100;
					$height = 100;
					if(isset($issue['image_width']) && is_Numeric($issue['image_width'])){
						$width = $issue['image_width'];
					}
					if(isset($issue['image_height']) && is_Numeric($issue['image_height'])){
						$height = $issue['image_height'];
					}
					?>
					<img src="<?php echo $issue['image']; ?>" alt="Issue image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;"/>
				<?php } ?>
				<h2><a href="#"><?php echo $issue['name']; ?></a></h2>
				<p><?php echo $issue['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $issue['participant_count']; ?> Participants</a> | <a href="#"><?php echo $issue['contribution_count']; ?> Contributions</a>
			</div>
		</div>		
	<?php } // end foreach ?>
		<div class="tab-links">
			<a class="viewButton" href="#">View All</a>
			<a class="collapseButton" href="#">Collapse</a>
		</div>
	</div>
<?php } // end if ?>	

<?php if(count($following) > 0){ ?>
	<div id="tabs-3">
	<?php 
		foreach($following  as $followed){ 
			$show = ($followed['show'] == 1) ? "show" : "hide";
	?>
		<div class="item <?php echo $show; ?>">
			<div class="above">
				<?php if(isset($followed['parent_image'])){ 
					$width = 100;
					$height = 100;
					if(isset($followed['parent_image_width']) && is_Numeric($followed['parent_image_width'])){
						$width = $followed['parent_image_width'];
					}
					if(isset($followed['parent_image_height']) && is_Numeric($followed['parent_image_height'])){
						$height = $followed['parent_image_height'];
					}
				?>
					<img src="<?php echo $followed['parent_image']; ?>" alt="followed image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;"/>
				<?php } ?>
				<h2><a href="<?php echo $followed['parent_url'] ?>" title="View"><?php echo $followed['parent_title']; ?></a></h2>
			</div>
			<div class="below">
				<a href="#"><?php echo $followed['participant_count']; ?> Participants</a> | <a href="#"><?php echo $followed['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
		<div class="tab-links">
			<a class="viewButton" href="#">View All</a>
			<a class="collapseButton" href="#">Collapse</a>
		</div>
	</div>
<?php } // end if ?>	
  </div>	
