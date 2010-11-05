
<?php
	if($is_my_profile):
?>
	<a href="/post_content.php">Create a Post</a><br />
	<a href="/content_management.php">Manage your Posts</a>
<?php
	endif;

	if($mode == $USERMODE) {
		require_once('user_contributions.tpl');
	} else {
		require_once('org_contributions.tpl');
	}
?>