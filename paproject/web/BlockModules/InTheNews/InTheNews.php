<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php
require_once "api/Permissions/PermissionsHandler.class.php";
require_once "api/Activities/Activities.php";
require_once "api/Messaging/MessageDispatcher.class.php";

class InTheNews extends Module {

	public $module_type = 'user|group|network';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_single_wide_module.tpl';
	public $content_id, $content;

	function __construct() {
		parent::__construct();
		$this->main_block_id = 'mod_permalink';
		$this->html_block_id = 'InTheNews';
	}

	function initializeModule($request_method, $request_data) {
		if(!empty($this->shared_data['content_info'])) {
			$this->content_id = $this->shared_data['content_info']->content_id;
		} else if(!empty($request_data['cid'])) {
			$this->content_id = $request_data['cid'];
		} else {
			return 'skip';
		}
	}

	function handleRequest($request_method, $request_data) {
	}

	function render() {
		$this->inner_HTML = $this->generate_inner_html();
		$content = parent::render();
		return $content;
	}

	function generate_inner_html() {
		return $this->shared_data['content_info']->body;
	}
}
?>
