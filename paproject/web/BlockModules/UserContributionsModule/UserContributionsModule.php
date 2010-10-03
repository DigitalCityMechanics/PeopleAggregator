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

class UserContributionsModule extends Module {

	public $module_type = 'user|network';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_module.tpl';

	private $_contributions;
	private $_thoughts;

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'UserContributionsModule';
	}

	public function initializeModule($request_method, $request_data)  {
		global $paging;	

		$this->title = "Contributions...";
		
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
	
		if(isset($page_uid)){

			$this->_contributions = $this->get_contributions_data($this->user->login_name);
			if(count($this->_contributions) == 0){
				$this->_contributions[] = array('title'=>'No contributions', 'summary'=>'You have not made any contributions.', 'participant_count' => 0, 'contribution_count' => 0);
			}

			$this->_thoughts = $this->get_thoughts_data($this->user->login_name);
			if(count($this->_thoughts) == 0){
				$this->_thoughts[] = array('title'=>'No thoughts', 'summary'=>'You have not shared in any thoughts.');
			}
			
			$this->inner_HTML = $this->generate_inner_html ();
			$content = parent::render();
		}
		return $content;
	}


	function generate_inner_html () {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/center_inner_public.tpl';

		$inner_html_gen = new Template($tmp_file);
		$inner_html_gen->set('contributions', $this->_contributions);
		$inner_html_gen->set('thoughts', $this->_thoughts);
		
		$inner_html = $inner_html_gen->fetch();
		return $inner_html;
	}


	/**
	 * Get contributions data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_contributions_data($User_id){
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
			$url = "http://staging.theciviccommons.com/api/$User_id/contributions";
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();
			if($responseStatus == 200){				
				return $request->getJSONResponse();
			}else{
    			Logger::log("UserContributionsModule.get_contributions_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
				return null;
			}
		}
		return null;
	}

	/**
	 * Get thoughts data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_thoughts_data($User_id){		
		return null;
	}
}
?>
