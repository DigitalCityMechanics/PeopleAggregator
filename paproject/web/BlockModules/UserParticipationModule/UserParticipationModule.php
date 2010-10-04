<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * UserParticipationModule.php is a part of PeopleAggregator.
 * This module is used to display 'conversations', 'issues' and 'following' data from a
 * third party web site which exposes the actual 'conversations', 'issues' and 'following' data in
 * a REST API
 *
 * 10/2/10	Parag Jagdale	Modified to plug real data into modules via REST cURL calls
 * 							and cleaned up example code
 * 9/10		Tom Dooner		Created Initial Module
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * @author Tom Dooner
 * @license http://bit.ly/aVWqRV PayAsYouGo License
 * @copyright Copyright (c) 2010 Broadband Mechanics
 * @package PeopleAggregator
 */
?>
<?php

require_once "web/includes/classes/CurlRequestCreator.php";
require_once "api/Logger/Logger.php";

class UserParticipationModule extends Module {

	public $module_type = 'user|network';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_module.tpl';

	private $_conversations;
	private $_issues;
	private $_following;

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'UserParticipationModule';
	}


	public function initializeModule($request_method, $request_data)  {
		global $paging;

		$this->title = "Participating In...";

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

			$this->_conversations = $this->get_conversations_data($this->user->login_name);
			if(count($this->_conversations) == 0){
				$this->_conversations[] = array('title'=>'No conversations', 'summary'=>'You are not participating in any conversations.', 'participant_count' => 0, 'contribution_count' => 0);
			}

			$this->_issues = $this->get_issues_data($this->user->login_name);
			if(count($this->_issues) == 0){
				$this->_issues[] = array('title'=>'No issues', 'summary'=>'You are not participating in any issues.', 'participant_count' => 0, 'contribution_count' => 0);
			}
			
			$this->_following = $this->get_following_data($this->user->login_name);
			if(count($this->_following) == 0){
				$this->_following[] = array('title'=>'Not following any conversations or issues', 'summary'=>'You are not following any issues of contributions', 'participant_count' => 0, 'contribution_count' => 0);
			}

			$this->inner_HTML = $this->generate_inner_html ();
			$content = parent::render();
		}
		return $content;
	}

	function generate_inner_html () {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/center_inner_public.tpl';

		$inner_html_gen = new Template($tmp_file);
		$inner_html_gen->set('conversations', $this->_conversations);
		$inner_html_gen->set('issues', $this->_issues);
		$inner_html_gen->set('following', $this->_following);

		$inner_html = $inner_html_gen->fetch();
		return $inner_html;
	}

	/**
	 * Get conversations data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_conversations_data($User_id){
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
			$url = "http://staging.theciviccommons.com/api/$User_id/conversations";
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();			
			if($responseStatus == 200){				
				return $request->getJSONResponse();
			}else{
    			Logger::log("UserParticipationModule.get_conversations_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
				return null;
			}
		}
		return null;
	}

	/**
	 * Get issues data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_issues_data($User_id){
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
			$url = "http://staging.theciviccommons.com/api/$User_id/issues";
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();			
			if($responseStatus == 200){				
				return $request->getJSONResponse();
			}else{
    			Logger::log("UserParticipationModule.get_issues_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
				return null;
			}
		}
		return null;
	}

	/**
	 * Get following data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_following_data($User_id){
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
			$url = "http://staging.theciviccommons.com/api/$User_id/following";
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();			
			if($responseStatus == 200){				
				return $request->getJSONResponse();
			}else{
    			Logger::log("UserParticipationModule.get_following_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
				return null;
			}
		}
		return null;
	}
}
?>
