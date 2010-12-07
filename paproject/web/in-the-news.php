<?php
	$login_required = FALSE;
	$use_theme = 'Beta';
	include_once("web/includes/page.php");

	function setup_module($column, $moduleName, $obj) {
		switch ($column) {
			case 'middle':
				$obj->title = 'In The News';
				break;
		}
	}

	$page = new PageRenderer("setup_module", PAGE_IN_THE_NEWS, "Civic Commons", "container_two_column_right.tpl", "header.tpl", PRI, HOMEPAGE, PA::$network_info);
	echo $page->render();
?>