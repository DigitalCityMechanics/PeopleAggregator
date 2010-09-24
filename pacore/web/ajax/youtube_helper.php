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
$use_theme = 'Beta'; //TODO : Remove this when new UI is completely implemented.

include_once("web/includes/page.php");
require_once "api/YouTube/YouTube.php";

// Now we are trying to get the data from the given id
if ( isset($_GET) && isset($_GET['url']) && !empty($_GET['url']) ) {
	echo YouTube::getEmbedHTML($_GET['url']);
}
?>