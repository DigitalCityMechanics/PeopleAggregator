<?php
	$login_required = FALSE;
	$use_theme = 'Beta';
	include_once("web/includes/page.php");

	function setup_module($column, $moduleName, $obj) {
		switch ($column) {
			case 'middle':
				$obj->outer_template = 'outer_public_module.tpl';
				$obj->title = null;
				break;
		}
	}

	$page = new PageRenderer("setup_module", PAGE_VIEW_POLL, "Poll", "container_two_column_right.tpl", "header.php", PUB, HOMEPAGE, PA::$network_info);
	echo $page->render();
?>