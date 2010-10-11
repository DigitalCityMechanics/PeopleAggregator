<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<link href="/Themes/Default/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" rel="stylesheet" />
<script src="/Themes/Default/javascript/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>

<style type="text/css">
div.participation {
	background-color:#FFF;
	margin-bottom:10px;
	padding:4px;
}
div.participation img {
	float:left;
	margin:0 13px 5px;
}
div.participation h2 {
	text-decoration:underline;
}
div.participation div.below {
	clear:both;
	padding:5px;
}
div.tab-links{text-align:right;}
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
	<?php foreach($conversations  as $conversation){ ?>
		<div class="participation">
			<div class="above">
				<?php if(isset($conversation['image'])){ 
					
					$width = 100;
					$height = 100;
					if(isset($conversation['parent_image_width']) && is_Numeric($conversation['parent_image_width'])){
						$width = $conversation['parent_image_width'];
					}
					if(isset($conversation['parent_image_height']) && is_Numeric($conversation['parent_image_height'])){
						$height = $conversation['parent_image_height'];
					}
					?>
					<img src="<?php echo $conversation['image']; ?>" alt="Conversation image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;"/>
				<?php } ?>
				<h2><a href="#"><?php echo $conversation['title']; ?></a></h2>
				<p><?php echo $conversation['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $conversation['participant_count']; ?> Participants</a> | <a href="#"><?php echo $conversation['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
		<div class="tab-links">
			<a href="<?php echo CC_APPLICATION_URL . CC_ROUTE_CONVERSATIONS; ?>">View All</a>
		</div>
	</div>
<?php } // end if ?>	

<?php if(count($issues) > 0){ ?>
	<div id="tabs-2">
	<?php foreach($issues  as $issue){ ?>
		<div class="participation">
			<div class="above">
				<?php if(isset($issue['image'])){
				
					$width = 100;
					$height = 100;
					if(isset($issue['parent_image_width']) && is_Numeric($issue['parent_image_width'])){
						$width = $issue['parent_image_width'];
					}
					if(isset($issue['parent_image_height']) && is_Numeric($issue['parent_image_height'])){
						$height = $issue['parent_image_height'];
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
			<a href="<?php echo CC_APPLICATION_URL . CC_ROUTE_ISSUES; ?>">View All</a>
		</div>
	</div>
<?php } // end if ?>	

<?php if(count($following) > 0){ ?>
	<div id="tabs-3">
	<?php foreach($following  as $followed){ ?>
		<div class="participation">
			<div class="above">
				<?php if(isset($followed['image'])){ 
				
					$width = 100;
					$height = 100;
					if(isset($followed['parent_image_width']) && is_Numeric($followed['parent_image_width'])){
						$width = $followed['parent_image_width'];
					}
					if(isset($followed['parent_image_height']) && is_Numeric($followed['parent_image_height'])){
						$height = $followed['parent_image_height'];
					}
				?>
					<img src="<?php echo $followed['image']; ?>" alt="Following image" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;"/>
				<?php } ?>
				<h2><a href="#"><?php echo $followed['title']; ?></a></h2>
				<p><?php echo $followed['summary']; ?></p>
			</div>
			<div class="below">
				<a href="#"><?php echo $followed['participant_count']; ?> Participants</a> | <a href="#"><?php echo $followed['contribution_count']; ?> Contributions</a>
			</div>
		</div>
	<?php } // end foreach ?>
		<div class="tab-links">
			<a href="<?php echo CC_APPLICATION_URL . CC_ROUTE_FOLLOWING; ?>">View All</a>
		</div>
	</div>
<?php } // end if ?>	
  </div>	