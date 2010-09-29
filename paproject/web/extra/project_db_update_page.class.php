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
ini_set('max_execution_time', 1200);
ini_set('max_input_time', 1200);

if (!defined('PA_DISABLE_BUFFERING'))
{
    define('PA_DISABLE_BUFFERING', TRUE);
}

$here = dirname(__FILE__);
require_once "$here/../../../project_config.php";
require_once 'web/includes/functions/functions.php';
require_once 'web/extra/db_update_page.class.php';

class project_db_update_page extends db_update_page
{
	public function do_updates()
    {
        // ALL DATABASE UPDATES GO IN HERE!
        // FOR EACH SQL STATEMENT YOU WANT TO EXECUTE, GIVE IT A 'KEY', THEN CALL:
        // $this->qup("key", "sql statement");
        // eg. $this->qup("new foobar table", "create table foobar (id int not null, primary key(id))");
        // YOU SHOULD NORMALLY PUT YOUR UPDATES AT THE *END* OF THIS FUNCTION.
        
        /** NOTE: KEY must be unique for each update query */
        
        /** EXAMPLE ADD NEW TABLE */
        /*
        $this->qup("new mc_feeds table",
                     "CREATE TABLE mc_feeds (
                     user_id int not null,
                     id int not null auto_increment,
                     primary key(user_id,id),
                     feed_url text not null,
                     feed_name varchar(255)
        )"); 
        */
        /** EXAMPLE ALTER TABLE */
        // $this->qup("add feed_description to mc_feeds", "ALTER TABLE mc_feeds ADD COLUMN feed_description TEXT");
        /** EXAMPLE INSERT INTO TABLE */
        // $this->qup("insert default data 1 for relation classifications", "INSERT INTO `relation_classifications` (`relation_type`, `relation_type_id`) VALUES ('acquaintance', '1');");
        /** EXAMPLE UPDATE TABLE */
        // $this->qup("changed id field in review-type movie", "UPDATE review_type SET review_id = 1 WHERE review_name = 'Movie'");
        // finally, run the 'safe' updates in net_extra.php.

		require_once('api/Conversation/Conversation.php');
		$this->qup(
			'2010-09-25, by: Jonathan Knapp - adding Conversation content_type',
			'INSERT INTO {content_types} (type_id, name, description) VALUES ('.Conversation::TYPE_ID.', "'.Conversation::TYPE_NAME.'", "'.Conversation::TYPE_DESCRIPTION.'")'
		);

		/**
		@todo: I don't like that I have to call the parent::do_updates() call after adding
		the project db updates, but I need to have the end of the parent's do_update()
		method actually make the calls.
		*/
		parent::do_updates();
	}
}