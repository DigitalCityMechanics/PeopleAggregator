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
require_once "api/BlogPost/BlogPost.php";
require_once "api/DB/Dal/Dal.php";

/**
 * A special kind of BlogPost, this class is for CC user Contributions in PA.
 * @extends BlogPost
 */
class Contribution extends BlogPost {

	const TYPE_ID = 14;
	const TYPE_NAME = 'Contribution';
	const TYPE_DESCRIPTION = 'A contribution created for Civic Commons';

	/**
	 * class Content::__construct
	 */
	public function __construct() {
		parent::__construct();
		$this->type = self::TYPE_ID;
	}

	public static function get_original_content_title($content_id) {
		$title = null;
		$res = Dal::query("SELECT title FROM {cc_contributions} WHERE content_id = ?", array($content_id));
		if ($res->numRows()) {
			while($row = $res->fetchRow(DB_FETCHMODE_OBJECT)) {
				return $row->title;
			}
		}
		return $title;
	}

	public static function get_original_content_url($content_id) {
		$url = null;
		$res = Dal::query("SELECT contribution_id, type FROM {cc_contributions} WHERE content_id = ?", array($content_id));
		if ($res->numRows()) {
			while($row = $res->fetchRow(DB_FETCHMODE_OBJECT)) {
				switch($row->type) {
					case 'issue':
						$url = CC_APPLICATION_URL.'/issues/'.$row->contribution_id;
						break;

					case 'conversation':
						$url = CC_APPLICATION_URL.'/conversations/'.$row->contribution_id;
						break;
				}
				return $url;
			}
		}
		return $url;
	}

	public static function table_exists() {
		$res = Dal::query("SHOW TABLES LIKE 'cc_contributions'");
		return ($res->numRows() > 0) ? true : false;
	}

	public static function save_contribution ($cid, $uid, $title, $body, $track, $tags, $ccid = 0, $is_active = 1, $display_on = 0, $is_default_content = FALSE) {
		// global var $path_prefix has been removed - please, use PA::$path static variable

		$errors = array();

		// ensure integers here
		$cid = (int)$cid;
		$uid = (int)$uid;
		$ccid = (int)$ccid;

		// if a new post, make one, otherwise load the existing one
		if ($cid) {
			$post = Content::load_content($cid, $uid);
			// ignore $ccid passed to function if the post already exists
			// - we don't allow users to move posts between
			// ContentCollections.
			$ccid = (int)$post->parent_collection_id;
		} else {
			$post = new Contribution();
			$post->author_id = $uid;
			if ($ccid) {
				$post->parent_collection_id = $ccid;
			}
		}

		if ($ccid && $ccid != -1) {
			$g = ContentCollection::load_collection($ccid, $uid);
			$g->assert_user_access($uid);
		} else {
			$g = NULL;
		}

		$post->title = $title;
		$post->body = $body;
		$post->allow_comments = 1;
		$post->is_active = $is_active;
		$post->display_on = $display_on;
		$post->trackbacks = '';
		if ($track) {
			$post->trackbacks = implode(",", $track);
		}
		$post->is_default_content = $is_default_content;
		$post->save();

		Tag::add_tags_to_content($post->content_id, $tags);

		if ($track) {
			foreach($track as $t) {
				if (!$post->send_trackback($t)) {
					$errors[] = array(
						"code" => "trackback_failed",
						"msg" => "Failed to send trackback",
						"url" => $t
					);
				}
			}
		}

		if ($g && !$cid) {
			// new post - post it to the group as well
			$g->post_content($post->content_id, $uid);
		}

		return array(
			"cid" => (int)$post->content_id,
			"moderation_required" => $g ? ($g->is_moderated == 1 && $g->author_id != $uid) : FALSE,
			"errors" => $errors
		);
	}
}
?>