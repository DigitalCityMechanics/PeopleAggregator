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

	public $module_type = 'user|network|group';
	public $module_placement = 'middle';
	public $outer_template = 'outer_public_center_module.tpl';
	
	public $mode = self::USERMODE;
	
	const USERMODE = 0;
	const ORGMODE = 1;
	
	private $uid;
	private $_contributions;
	private $_thoughts;

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'UserContributionsModule';
	}

	public function initializeModule($request_method, $request_data)  {
		global $paging;	

		$this->title = "Contributions";
		
		if(!empty($this->shared_data['user_info'])) {
			$this->user = $this->shared_data['user_info'];
			$this->uid = $this->user->user_id;
			$this->mode = self::USERMODE;
		}else if(!empty($this->shared_data['group_info'])){
			$this->group = $this->shared_data['group_info'];
			$this->uid = $this->group->owner_id;
			$this->mode = self::ORGMODE;
		} else {
			return 'skip';
		}
	}

	function render() {
		global $login_uid, $page_uid;
		$content = null;
		
		$this->_contributions = $this->get_contributions_data($this->uid);
		
		if($this->mode == self::USERMODE){
			$this->_thoughts = $this->get_thoughts_data($this->uid);
		}else if($this->mode == self::ORGMODE){
			$this->_thoughts = $this->get_posts_data($this->uid);
		}
	
		$this->inner_HTML = $this->generate_inner_html();
		$content = parent::render();

		return $content;
	}


	function generate_inner_html () {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/center_inner_public.tpl';

		$inner_html_gen = new Template($tmp_file);
		$inner_html_gen->set('contributions', $this->_contributions);
		$inner_html_gen->set('thoughts', $this->_thoughts);
		$inner_html_gen->set('mode', $this->mode);
		$inner_html_gen->set('USERMODE', self::USERMODE);
		$inner_html_gen->set('ORGMODE', self::ORGMODE);
		$inner_html_gen->set('is_my_profile', isset($this->shared_data['is_my_profile']) ? $this->shared_data['is_my_profile'] : false);
		
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
			$url = $this->buildRESTAPIUrl(CC_APPLICATION_URL, CC_APPLICATION_URL_TO_API, CC_ROUTE_CONTRIBUTIONS, $User_id);
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$defaultResult = array('show'=>true, 'parent_title'=>'No contributions', 'url'=>'#', 'parent_url'=> CC_APPLICATION_URL . CC_ROUTE_CONVERSATIONS, 'comment'=>'You have not made any contributions.', 'participant_count' => 0, 'contribution_count' => 0);
			$responseStatus = $request->createCurl();
			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}else{
					// only show the first 3 conversations
					$newArray = $this->setItemsToShow($jsonResults, NUM_OF_ITEMS_TO_SHOW_PARTICIPATION_CONTRIBUTIONS);
					$jsonResults = $newArray;
				}
				return $jsonResults;
			}else{
    			Logger::log("UserContributionsModule.get_contributions_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
				return array($defaultResult);
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
		//TODO: throw exceptions and check for bad error codes
		//TODO: put URL in App_Config.xml
		// TEMPORARY TEST CODE, REMOVE LATER
		if(isset($_GET['testuser'])){
			$User_id = $_GET['testuser'];
		}
		if(isset($User_id)){
//			$url = $this->buildRESTAPIUrl(PA::$url, CC_APPLICATION_URL_TO_API, CC_ROUTE_THOUGHTS, $User_id);
			$url = 'http://www.peeps.com/api/json.php/civiccommons/thoughts';
			$request = new CurlRequestCreator($url, true, 30, 4, false, true, false);
			$request->setPost(array('user_id' => $User_id));
			$defaultResult = array('show'=>true, 'parent_title'=>'No thoughts', 'url'=>'#', 'parent_url'=> CC_APPLICATION_URL . CC_ROUTE_CONVERSATIONS, 'comment'=>'You have not shared any thoughts.', 'participant_count' => 0, 'contribution_count' => 0);
			$responseStatus = $request->createCurl();
			if($responseStatus == 200){
				$jsonResults = $request->getJSONResponse();
				if(count($jsonResults) == 0){
					$jsonResults[] = $defaultResult;
				}else{
					// only show the first 3 conversations
					$newArray = $this->setItemsToShow($jsonResults, NUM_OF_ITEMS_TO_SHOW_PARTICIPATION_CONTRIBUTIONS);
					$jsonResults = $newArray;
				}
				return $jsonResults;
			}else{
    			Logger::log("UserContributionsModule.get_contributions_data() could not get data from the cURL request. URL: $url | HTTP Response Status: $responseStatus", LOGGER_WARNING);				
				return array($defaultResult);
			}
		}
		return null;
	}
	
	
	/**
	 * Get posts data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_posts_data($User_id){		
		return array(array('show'=>true, 'title'=>'No posts', 'summary'=>'You have not shared in any posts.'));
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
	
	/**
	 * Changes array to show certain items
	 * @param $ArrayToChange
	 * @param $NumberOfItemsToShow
	 */
	function setItemsToShow($ArrayToChange, $NumberOfItemsToShow){	
		$i = 0;
		foreach($ArrayToChange as $arrayItem){
			
			if($i < $NumberOfItemsToShow){
				$arrayItem['show'] = true;
			}else{
				$arrayItem['show'] = false;
			}
			$ArrayToChange[$i] = $arrayItem;
			$i++;
		}
		return $ArrayToChange;
	}
	
}
?>
