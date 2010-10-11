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
		//TODO: Do a check for private page, public page or org page
		//if(isset($page_uid)){			
			$this->_conversations = $this->get_conversations_data($this->user->user_id);
				
			$this->_issues = $this->get_issues_data($this->user->user_id);
				
			$this->_following = $this->get_following_data($this->user->user_id);

			$this->inner_HTML = $this->generate_inner_html ();
			$content = parent::render();
		//}
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
			$url = $this->buildRESTAPIUrl(CC_APPLICATION_URL, CC_APPLICATION_URL_TO_API, CC_ROUTE_CONVERSATIONS, $User_id);
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();
			$defaultResult = array('title'=>'No conversations', 'summary'=>'You are not participating in any conversations.', 'participant_count' => 0, 'contribution_count' => 0);
			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}else{
					// only show the first 3 conversations
					$newArray = array_splice($jsonResults, 1, 3);
					$jsonResults = $newArray;
				}				
				return $jsonResults;
			}else{
				Logger::log("UserParticipationModule.get_conversations_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);
				return array($defaultResult);
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
			$url = $this->buildRESTAPIUrl(CC_APPLICATION_URL, CC_APPLICATION_URL_TO_API, CC_ROUTE_ISSUES, $User_id);
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();
			$defaultResult = array('name'=>'No issues', 'summary'=>'You are not participating in any issues.', 'participant_count' => 0, 'contribution_count' => 0);
			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}else{
					// only show the first 3 conversations
					$newArray = array_splice($jsonResults, 1, 3);
					$jsonResults = $newArray;
				}				
				return $jsonResults;
			}else{
				Logger::log("UserParticipationModule.get_issues_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);
				return array($defaultResult);
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
			$url = $this->buildRESTAPIUrl(CC_APPLICATION_URL, CC_APPLICATION_URL_TO_API, CC_ROUTE_FOLLOWING, $User_id);
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$responseStatus = $request->createCurl();
			$defaultResult = array('title'=>'Not following any conversations or issues', 'summary'=>'You are not following any issues of contributions', 'participant_count' => 0, 'contribution_count' => 0);
			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}else{
					// only show the first 3 conversations
					$newArray = array_splice($jsonResults, 1, 3);
					$jsonResults = $newArray;
				}				
				return $jsonResults;
			}else{
				Logger::log("UserParticipationModule.get_following_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);
				return array($defaultResult);
			}
		}
		return null;
	}
	
	/**
	 * Creates a URL from the given parts into a usable REST URL
	 * Note: this function is customized for the CivicCommons project URLs (ie. http://www.example.com/$APIFolder/$ObjectIdentifier/$ObjectType
	 * @param string $SiteURL				Base Site URL to the REST API (ie. http://www.example.com)
	 * @param string $APIFolder				The folder that lets the web site know that the API is being called (ie. http://www.example.com/api) 
	 * @param string $ObjectType			The type of object to get (ie. to get conversations, append a api/conversations to the end to get the objects of that type)
	 * @param string $ObjectIdentifier		The identifier of the specific object to get
	 */
	function buildRESTAPIUrl($SiteURL, $APILink, $ObjectType, $ObjectIdentifier){
		//TODO: add ability to remove double slashes
		$url = $SiteURL . $APILink . "/" . $ObjectIdentifier . $ObjectType;
		return $url;
	}
	
}
?>
