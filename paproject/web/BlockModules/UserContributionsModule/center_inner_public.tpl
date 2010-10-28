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
<?php global $login_uid; ?>

<div id="tabs-contributions">
<?php
	if($is_my_profile) {
?>
	<a href="/post_content.php">Create a Post</a><br />
	<a href="/content_management.php">Manage your Posts</a>
<?php
	}
?>
	<ul>
	<?php if($mode == $USERMODE){ ?>
			<li><a href="#tabs-contributions-1">Contributions</a></li>
			<li><a href="#tabs-contributions-2">Thoughts</a></li>
	<?php }else if($mode == $ORGMODE){ ?>	
			<li><a href="#tabs-contributions-1">Posts</a></li>
			<li><a href="#tabs-contributions-2">Contributions</a></li>
	<?php } ?>
	</ul>
<?php
	if($mode == $USERMODE) {
		require_once('contributions.tpl');
		require_once('thoughts.tpl');
	} else {
		require_once('thoughts.tpl');
		require_once('contributions.tpl');
	}
?>
</div>