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
$login_required = FALSE;
$use_theme = 'Beta';
include_once "web/includes/page.php";
require_once "api/Poll/Poll.php";

if (!empty($_POST['vote'])) {
  $vote = $_POST['vote'];
  $vote = html_entity_decode(stripslashes($vote));
  $poll_id = $_POST['poll_id'];

  if (PA::$login_uid) {
    $uid = PA::$login_uid;
    $obj = new Poll();
    $obj->poll_id = $poll_id;
    $obj->vote = $vote;
    $obj->user_id = $uid;
    $obj->is_active = ACTIVE;
    $obj->save_vote();
	echo 'good to go!';
  } else {
	echo 'please login first...';
  }
}

print_r($_POST);
exit();

?>