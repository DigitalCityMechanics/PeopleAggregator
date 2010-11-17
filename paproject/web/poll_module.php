<?php
	require_once "web/BlockModules/PollModule/PollModule.php";

	$poll_module = new PollModule();
	$poll_module->title = null;
	echo $poll_module->render();
?>