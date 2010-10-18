<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * UserContributionsModule.php is a part of PeopleAggregator.
 * This module is used to display the user's 'contributions' and 'thoughts' data.
 * The contributions data is returned from party web site which exposes the actual 'contributions' data.
 * The thoughts data come from PeopleAggregator
 * a REST API
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @author [creator, or "Original Author"]
 * @license http://bit.ly/aVWqRV PayAsYouGo License
 * @copyright Copyright (c) 2010 Broadband Mechanics
 * @package PeopleAggregator
 */
?>
<?php
require_once "web/includes/classes/CurlRequestCreator.php";
require_once "api/Logger/Logger.php";

class UserNameModule extends Module {

	public $module_type = 'user|network';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_module.tpl';

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'UserNameModule';
	}

	public function initializeModule($request_method, $request_data)  {
		global $paging;	

		$this->title = '';
		
		if(!empty($this->shared_data['user_info'])) {
			$this->user = $this->shared_data['user_info'];
			$this->uid = $this->user->user_id;
		} else {
			return 'skip';
		}
	}

	function render() {
		global $login_uid, $page_uid;

		$content = null;
		$this->inner_HTML = $this->generate_inner_html();
		$content = parent::render();

		return $content;
	}


	function generate_inner_html() {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/center_inner_public.tpl';

		$inner_html_gen = new Template($tmp_file);
		$first_name = (isset($this->user) && isset($this->user->first_name)) ? $this->user->first_name : '';
		$last_name = (isset($this->user) && isset($this->user->last_name)) ? $this->user->last_name : '';
		$username = ($first_name != '') ? $first_name : '';
		$username .= ($last_name != '') ? ' '.$last_name : '';
		$inner_html_gen->set('title', $username);
		
		$inner_html = $inner_html_gen->fetch();
		return $inner_html;
	}
}
?>