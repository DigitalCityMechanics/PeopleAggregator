<?php
	if($mode == $USERMODE) {
		require_once('user_contributions.tpl');
	} else {
		require_once('org_contributions.tpl');
	}
?>