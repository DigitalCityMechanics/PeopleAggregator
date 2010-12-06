<?php
/** !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * ThoughtsListModule.php is a part of PeopleAggregator.
 * This module is used to display thoughts a user has made. If there are no thoughts, the
 * module is not rendered. In addition it includes a new module
 * a REST API
 *
 * 10/31/10	Parag Jagdale	Created Initial Module
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

class ThoughtsListModule extends Module {

	public $module_type = 'user|group'; 
	public $module_placement = 'left|right';
	public $outer_template = 'outer_public_side_module.tpl';
	public $per_option;
	
	private $uid;
	private $_conversations;
	private $_issues;
	private $_following;

	function __construct() {
		parent::__construct();
		$this->html_block_id = 'ThoughtsListModule';
	}


	public function initializeModule($request_method, $request_data)  {
		global $paging;

		$this->title = "My Thoughts";			

		if(!empty($this->shared_data['user_info'])) {
			$this->user = $this->shared_data['user_info'];
			$this->uid = $this->user->user_id;
		}else if(!empty($this->shared_data['group_info'])){
			$this->group = $this->shared_data['group_info'];
			$this->uid = $this->group->owner_id;
		} else {
			return 'skip';
		}
				
		$this->_thoughts = $this->get_user_thoughts_data($this->uid);
		if(!isset($this->_thoughts)
			|| count($this->_thoughts) == 0
			|| (isset($this->_thoughts) && !empty($this->_thoughts) && count($this->_thoughts) == 1 && isset($this->_thoughts[0]['default']) && $this->_thoughts[0]['default'] == true)){
			return 'skip';		
		}
	}


	function render() {
		global $login_uid, $page_uid;
		$content = null;
		$this->inner_HTML = $this->generate_inner_html ();
		$content = parent::render();

		return $content;
	}

	function generate_inner_html () {

		$tmp_file = PA::$blockmodule_path .'/'. get_class($this) . '/side_inner_public.tpl';
             
		$inner_html_gen = new Template($tmp_file);
		$inner_html_gen->set('thoughts', $this->_thoughts);
		
		if(isset($this->shared_data) && isset($this->shared_data['is_my_profile']) && !empty($this->shared_data['is_my_profile'])){
			if($this->shared_data['is_my_profile'] == true){
				$inner_html_gen->set('manage_thoughts_url', PA::$url . "/content_management.php");
			}
		}
		

		$inner_html = $inner_html_gen->fetch();
		return $inner_html;
	}

	/**
	 * Get thoughts data.
	 * @param 	$User_id
	 * @return	an associative array of the response data. If no data is present or there is an error, no data is returned
	 */
	function get_user_thoughts_data($User_id){
		$thoughts  = null;
		$thoughtsToReturn = array();
		$thoughts = Content::get_user_content($User_id);
		if(isset($thoughts) && is_array($thoughts) && count($thoughts) > 0) {
			foreach($thoughts as $thought) {
				if($thought['type'] != CONTRIBUTION){
					$thought['show'] = true;
					$thought['title'] = $thought['title'];
					$thought['image'] = null;
					$thought['image_width'] = null;
					$thought['image_height'] = null;
					$thought['summary'] = $thought['body'];
					$thought['url'] = PA::$url.'/content/cid='.$thought['content_id'];
					$thoughtsToReturn[] = $thought;
				}
			}
		} else {
			$thoughtsToReturn = array(array('default'=>true, 'show'=>true, 'title'=>'No thoughts', 'summary'=>'No content published. <a href="/thought_content.php">Click here to add content</a>.'));
		}
		return $thoughtsToReturn;
	}


		/**
	 * Get thoughts data.
	 * @param 	$org_id
	 * @return	an associative array of the response data. If no data is present or there is an error, generic data is returned
	 */
	function get_org_thoughts_data($org_id){
		$org = new Group();
		$org->collection_id = $org_id;
 		$thoughts = $org->get_contents_for_collection('all', FALSE, 'ALL', 0, 'created', 'DESC', TRUE);

		if(isset($thoughts) && is_array($thoughts) && count($thoughts) > 0) {
			$thoughts = array();
			foreach($thoughts as $thought) {
				$thought['show'] = true;
				$thought['title'] = $thought['title'];
				$thought['image'] = null;
				$thought['image_width'] = null;
				$thought['image_height'] = null;
				$thought['summary'] = $thought['body'];
				$thought['url'] = PA::$url.'/content/cid='.$thought['content_id'];
				$thoughts[] = $thought;
			}
		} else {
			$thoughts = array(array('show'=>true, 'title'=>'No thoughts', 'summary'=>'No content published. <a href="/thought_content.php?ccid='.$org_id.'">Click here to add content</a>.'));
		}
		return $thoughts;
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
